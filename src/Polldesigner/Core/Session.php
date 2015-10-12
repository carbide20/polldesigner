<?php

namespace Polldesigner\Core;
use Polldesigner\Models as Models;

class Session {


    private $table = 'sessions';
    private $id;
    private $user;


    /**
     * When the constructor is called, it is passed the current user object
     * and a new session is created. The session ID & user ID are stored
     * in the DB session table, and timestamped so we can later time them out
     *
     * @param $database - an instance of the Database model
     */
    public function __construct(Database $database) {

        $this->database = $database;

    }


    /**
     * This one actually fires up the session and links it to the current user
     * @param User $user - The current user object
     * @return bool - True if successful, otherwise false
     */
    public function start(Models\User $user) {

        // First, kill any session they may already have
        $this->expireSession();

        // Open a new session
        session_start();

        // Save the session ID to the object
        $this->id = session_id();

        // Save the user object
        $this->user = $user;

        // Write the data to the DB
        if (!$this->store()) { return false; }

        return true;

    }

    private function store() {

        // Check to make sure we have everything we need
        if (!($this->id && $this->user->id)) {
            return false;
        }

        // Insert the session data we have into the DB
        return $this->database->insert(
            $this->table,
            array('session_id' => $this->id,
                'user_id' => $this->user->id,
                'created_at' => date("Y-m-d H:i:s"))
        );

    }


    public function renewSession() {

//        User already logged in hits a page where they need to authenticate. We are passed the user object
//        User not logged in hits a page where they have to be authenticated. We are passed the user object
//            Do they have a session object that matches the ID of the $user object?
//            Yes
//                All good, return true and renew session time
//                redirect to login page
//            No
//                Expire the session, redirect to login


    }

    public function expireSession() {

        // The long and complicated way php.net suggested being completely, absolutely, positively, and utterly
        // sure that the session is gone.
        if (!session_status() === PHP_SESSION_ACTIVE) {

            // Initialize the session.
            session_start();

        }

        // Unset all of the session variables.
        $_SESSION = array();

        // Also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finally, destroy the session.
        session_destroy();

        //redirect to: TIMEOUT_PAGE
    }



}
