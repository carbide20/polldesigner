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
class PollMapper {



    private $database, $session;


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
        $user->id = intval($userdata['id']);
        $user->username = $userdata['username'];
        $user->loaded = true;

        // Give them the new user
        return $user;

    }


    public function loadAll() {

        // Run the query to get the poll data
        $sql = $this->database->getHandle()->prepare("SELECT * FROM polls WHERE user_id = :user_id");
        $sql->execute(array(":user_id" => $this->session->getUserId()));

        // Try to load up the polldata
        $polldata = $sql->fetchAll();


        // If we did not find the poll, return false so the caller knows
        if (!$polldata) {
            return false;
        }

        // this will hold the final array of poll objects for return
        $polls = array();

        // Loop through the polldata, and instantiate poll objects with it
        foreach($polldata as $poll) {

            // Instantiate a new poll Models
            $pollInstance = new Poll();

            // Set the user's properties
            $pollInstance->id = intval($poll['id']);
            $pollInstance->name = $poll['name'];
            $pollInstance->loaded = true;

            // Add the new poll instance to the final array
            $polls[] = $pollInstance;

        }

        // Send back the polls, as long as we have at least one
        return count($polls) > 0 ? $polls : false;

    }


}