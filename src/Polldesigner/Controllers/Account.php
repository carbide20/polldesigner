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


namespace Polldesigner\Controllers;

use Polldesigner\Core as Core;
use Polldesigner\Models as Models;


/**
 * Class Account - Handles account-related actions
 * @package Polldesigner\Controllers
 */
class Account extends Core\Controller {


    /**
     * Constructor passes needed info up to the parent controller
     *
     * @param Core\Database $database - Give us access to the database object & handler
     * @param Core\Session $session - The session object
     * @param $request - array of page request data
     */
    public function __construct(Core\Database $database, Core\Session $session, $request) {
        parent::__construct($database, $session, $request);
    }


    /**
     * Renders the account page
     */
    public function indexAction() {

        // Get a Views object
        $view = new Core\View($this);

        // Authenticate the user
        $this->session->auth();

        // Instantiate a new PollMapper so we can work with polls
        $pollMapper = new Models\PollMapper($this->database, $this->session);

        // Get all the polls associate with this user
        $polls = $pollMapper->loadAll();

        // Render the Views
        $view->render('header');
        $view->render('notifications');
        $view->render('account', array('polls' => $polls));
        $view->render('footer');
        exit;

    }




    /**
     * Handles user logout. Expires the session, and then redirects
     * them to the home page
     */
    public function logoutAction() {

        // Kill their current session
        $this->session->expireSession();

        // Redirect back to homepage
        header("HTTP/1.1 303 See Other");
        header("Location: " . SITE_ROOT);
        exit;

    }


}