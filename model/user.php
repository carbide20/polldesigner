<?php
/**
 * @Project: Poll designer
 * @Author: Dan Hennion
 * @Date: 09/30/2015
 * @Purpose: This project is designed to serve as a sample
 *  of my code. As such, it is not built on any existing framework
 *  and 100% of the code is my own. The app is designed with my
 *  interpretation of MVC
 */
namespace Model;

class UserModel extends \Core\AbstractEntity {

    private $dbh;
    private $id, $username, $password;
    private $loaded = false;


    public function __construct($dbh) {
        $this->dbh = $dbh;
    }



    /**
     * Takes whatever information we have about a user, and attempts to load the account if possible
     * @return mixed - Array
     */
    public function load() {

        // First try to load by ID if we have it
        if ($this->id > 0) {

            $sql = $this->dbh->prepare("SELECT * FROM users WHERE id = ?");
            $sql->execute(array($this->id));

            // Try to load up the userdata
            $userdata = $sql->fetch();

        // Next, try by username
        } else if ($this->username) {

            $sql = $this->dbh->prepare("SELECT * FROM users WHERE username = ?");
            $sql->execute(array($this->username));

            // Try to load up the userdata
            $userdata = $sql->fetch();

        }

        // If we did find userdata, update ourselves
        if ($userdata) {

            $this->id = $userdata['id'];
            $this->username = $userdata['username'];
            $this->loaded = true;

        }

        // Give them back the updated user object
        return $this;

    }


    public static function authenticate() {

    }

    public static function login($username, $password) {

    }


    public static function register($username, $password) {

        $user = new User($username);

    }

}