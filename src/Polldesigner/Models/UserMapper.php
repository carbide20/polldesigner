<?php
/**
 * @Project: Poll designer
 * @Author: Dan Hennion
 * @Date: 09/30/2015
 * @Purpose: This project is designed to serve as a sample
 *  of my code. As such, it is not built on any existing framework
 *  and 100% of the code is my own, except for the Composer PSR-4
 *  autoload functionality. The app is designed with my
 *  interpretation of MVC in mind.
 */


namespace Polldesigner\Models;

use Polldesigner\Core as Core;


/**
 * The UserMapper is responsible for handling our user functionality,
 * on a different layer from the user class itself, which is only
 * responsible for knowing of, setting, and getting its own properties
 */
class UserMapper {



    private $database, $session, $user;


    /**
     * Requires the database and the session, and then creates a new shell user to populate with data
     * @param Core\Database $database
     * @param Core\Session $session
     */
    public function __construct(Core\Database $database, Core\Session $session) {

        // Save the database instance
        $this->database = $database;

        // Save the session
        $this->session = $session;

        // Create a new user shell to use
        $this->user = new User();

    }

    /**
     * Serves as a factory for instantiating new User models
     *
     * @param $id - The ID of the user to load
     * @return Object - An instance of the user Model
     */
    public function loadById($id) {

        // Throw an exception if we don't have a proper ID
        if (!($id > 0)) {
            throw new \BadFunctionCallException("ID Required for UserMapper->loadById(\$id)");
        }

        // Run the query to get the userData
        $sql = $this->database->getHandle()->prepare("SELECT * FROM users WHERE id = :id");
        $sql->execute(array(":id" => $id));

        // Try to load up the userdata
        $userdata = $sql->fetch();

        // If we did not find the user, return false so the caller knows
        if (!$userdata) {
            return false;
        }

        // Instantiate a new user Models
        $user = new User();

        // Set the user's properties
        $user->id = $userdata['id'];
        $user->username = $userdata['username'];
        $user->loaded = true;

        // Give them the new user
        return $user;

    }


    /**
     * Takes registration formdata, and tries to register the user
     * @param $formdata
     * @return bool - true on successful registration, otherwise false
     */
    public function register($formdata) {

        // TODO: Add some rate-limiting here for brute forcing

        // Run a select on the DB against this username. Let's check to see if it's already in use
        $results = $this->database->select($this->user->table, array('id'), array('username' => $formdata['username']) );

        // If we got results back, the username is already in use
        if (!empty($results)) {

            // Set a session error here so we can tell the user what happened, and return false
            $_SESSION['errors'][] = "cannot register, name taken";
            return false;

        }

        // Encrypt the password
        $hashedPassword = $this->generateHash($formdata['password']);

        // Create the account
        if (!$this->database->insert($this->user->table, array('username' => $formdata['username'], 'password' => $hashedPassword))) {

            // The insert failed for some reason
            $_SESSION['errors'][] = "The system was unable to register your account. Please try again later.";
            return false;

        }

        // Fire up the session, saving it to our DB as well
        if (!$this->session->start($this->user)) {

            // The insert failed for some reason
            $_SESSION['errors'][] = "Please ensure that you have cookies enabled, and try again.";
            return false;

        }

        // Set a session success welcoming them to their account, and return true
        $_SESSION['successes'][] = "Your account has been created successfully, " . $formdata['username'] . ".";
        return true;

    }


    /**
     * Takes login formdata, and then tries to log the user in
     * @param $formdata
     * @return bool
     */
    public function login($formdata) {

        // TODO: Add some rate-limiting here for brute forcing

        // Do the database lookup to see
        $results = $this->database->select($this->user->table, array('id', 'username', 'password'), array('username' => $formdata['username']) );

        // Check the password against the encrypted one in the DB
        if ($this->verify($formdata['password'], $results['password'])) {

            // Now that we've logged them in, set the important stuff on the user model
            $this->user->username = $results['username'];
            $this->user->id = intval($results['id']);
            $this->user->loaded = true;

            // Fire up the session, saving it to our DB as well
            if (!$this->session->start($this->user)) {

                // The insert failed for some reason
                $_SESSION['errors'][] = "Please ensure that you have cookies enabled, and try again.";
                return false;

            }

        } else {

            // The insert failed for some reason
            $_SESSION['errors'][] = "We were unable to log you in with the credentials you provided.";
            return false;

        }

        // Set a session success welcoming them to their account, and return true
        $_SESSION['successes'][] = "You have been logged in successfully, " . $formdata['username'] . ".";
        return true;

    }


    /**
     * Takes the attempted password, and compares it with the hashed
     * password we keep in our DB. It uses bcrypt's comparison functionality.
     *
     * @param $password - This is the one coming from the user trying to login
     * @param $encryptedPassword - This should be a bcrypt'ed password from our DB
     * @return bool
     */
    private function verify($password, $encryptedPassword) {

        return crypt($password, $encryptedPassword) == $encryptedPassword;

    }


    /**
     * Takes a plaintext password, and uses bcrypt to encrypt it for DB
     * storage. Bcrypt is designed much better than anything I could write
     * for this, and is also nice and slow to thwart off goblins, so they
     * can't mess with it so hard.
     *
     * @param $password
     * @return string
     */
    private function generateHash($password) {
        if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
            $salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
            return crypt($password, $salt);
        }
    }


}