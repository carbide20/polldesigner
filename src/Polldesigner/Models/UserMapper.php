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
class UserMapper extends Core\DataMapper {


    private $user;


    public function __construct(\PDO $dbh) {

        // Pass the database handle up to the core mapper
        parent::__construct($dbh);

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
        $sql = $this->dbh->prepare("SELECT * FROM users WHERE id = :id");
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
        $user->id($userdata['id']);
        $user->username($userdata['username']);
        $user->loaded(true);

        // Give them the new user
        return $user;

    }


    /**
     * Takes registration formdata, and tries to register the user
     * @param $postdata
     * @return bool - true on successful registration, otherwise false
     */
    public function register($formdata) {

        // Run a select on the DB against this username. Let's check to see if it's already in use
        $results = $this->select($this->user->table, array('id'), array('username' => $formdata['username']) );

        // If we got results back, the username is already in use
        if (!empty($results)) {

            // Set a session error here so we can tell the user what happened, and return false
            $_SESSION['errors'][] = "cannot register, name taken";
            return false;

        }

        // Encrypt the password
        $hashedPassword = $this->generateHash($formdata['password']);

        // Create the account
        if (!$this->insert($this->user->table, array('username' => $formdata['username'], 'password' => $hashedPassword))) {

            // The insert failed for some reason
            $_SESSION['errors'][] = "The system was unable to register your account. Please try again later.";
            return false;

        }

        // Set a session success welcoming them to their account, and return true
        $_SESSION['successes'][] = "Your account has been created successfully, " . $formdata['username'] . ".";
        return true;

    }

    public function login($formdata) {

        $results = $this->select($this->user->table, array('id', 'password'), array('username' => $formdata['username']) );

        echo '<pre>'; var_dump($formdata); echo '</pre>';
        echo '<pre>'; var_dump($results); echo '</pre>';
        die();
        if (!$this->verify($formdata['password'], $results['password'])) {

            // The insert failed for some reason
            $_SESSION['errors'][] = "We were unable to log you in with the credentials you provided.";
            return false;

        }

    }

    public function authenticate() {

    }


    private function verify($password, $hashedPassword) {

        return crypt($password, $hashedPassword) == $hashedPassword;
    }

    private function generateHash($password) {
        if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
            $salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
            return crypt($password, $salt);
        }
    }

}