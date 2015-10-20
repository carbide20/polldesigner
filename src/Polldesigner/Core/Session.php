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

        // Make sure we can work with sessions
        if ( !is_writable(session_save_path()) ) {
            throw new Exception('Session save path "'.session_save_path().'" is not writable!');
        }

    }


    /**
     * This one actually fires up the session and links it to the current user
     * @param User $user - The current user object
     * @return bool - True if successful, otherwise false
     */
    public function start(Models\User $user) {

        // Check to see if they need a new session
        if (session_status() !== PHP_SESSION_ACTIVE) {

            // Open a new session
            session_start();

        }

        // Save the session ID to the object
        $this->id = session_id();

        // Save the user object
        $this->user = $user;

        // Write the data to the DB
        if (!$this->store()) { return false; }

        return true;

    }


    /**
     * This stores the session information in the DB
     *
     * @return bool - true on successful insert, otherwise false
     */
    private function store() {

        // Check to make sure we have everything we need
        if (!($this->id) || !($this->user->id > 0)) {
            return false;
        }

        // See if we have a session that we can just renew before we start a new one
        if (!$this->renew()) {

            // Insert the session data we have into the DB
            return $this->database->insert(
                $this->table,
                array('session_id' => $this->id,
                    'user_id' => $this->user->id,
                    'created_at' => date("Y-m-d H:i:s"))
            );

        }

    }


    public function auth() {

        // Check if the session is not active. we also do the renewal with this check if it is active, so need to
        // later on pages that call auth().
        if (!$this->renew()) {

            // The session is expired
            $_SESSION['errors'][] = "Your session has timed out for security. Please login again.";

            // Redirect back, so the errors can be displayed
            header("HTTP/1.1 303 See Other");
            header("Location: " . SITE_ROOT . "login");
            exit;

        }


    }


    // This will have to be written to be called from non-auth pages, just for renewal
    // if the session is expired, we do nothing, and return false
    public function renew() {

        // See if they have an active session
        if (session_status() === PHP_SESSION_ACTIVE) {

            // Update our class, make sure we still know the user's session ID
            $this->id = session_id();

            // Now we can use the updated ID to do a DB lookup
            $result = $this->database->select($this->table, array('user_id', 'session_id', 'created_at'), array('session_id' => $this->id));
            if (!$result) { return false; }

            // See if the session IDs match
            if (empty($result) || !array_key_exists('session_id', $result) || $result['session_id'] !== $this->id) {
                return false;
            }

            // Calculate timeout time
            $time = new \DateTime($result['created_at']);
            $time->add(new \DateInterval('PT' . TIMEOUT_TIME . 'M'));
            $timeoutTime = $time->format('Y-m-d H:i:s');

            // Check to see if the session needs to expire
            if (date('Y-m-d H:i:s') >= $timeoutTime) {

                // It's time for the session to go
                $this->expireSession();
                return false;

            // Otherwise we gotta revive this thing
            } else {

                // TODO: check if this fails
                // Update the session expiry and return true
                $this->database->update($this->table, array('created_at' => date('Y-m-d H:i:s')), array('session_id' => $this->id, 'user_id' => $result['user_id']));

                // Update the this class
                if (!$this->user) {
                    $this->user = new Models\User();
                    $this->user->id = $result['user_id'];
                }

                return true;

            }

        // No active session, return false
        } else {

            return false;

        }

    }

    public function expireSession() {

        // The long and complicated way php.net suggested being completely, absolutely, positively, and utterly
        // sure that the session is gone. I know it doesn't make a lot of sense to start a session in this file,
        // but bear with me. We've gotta start it, to empty it, to destroy it.
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

    }



}
