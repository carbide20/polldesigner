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


namespace Core;


/**
 * The UserMapper is responsible for handling our user functionality,
 * on a different layer from the user class itself, which is only
 * responsible for knowing of, setting, and getting its own properties
 */
class UserMapper extends Mapper {

    /**
     * Serves as a factory for instantiating new User Models
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
        $user = new \Model\User();

        // Set the user's properties
        $user->setId($userdata['id']);
        $user->setUsername($userdata['username']);
        $user->setLoaded(true);

        // Give them the new user
        return $user;

    }

    public function register() {

    }

    public function login() {

    }

    public function authenticate() {

    }

}