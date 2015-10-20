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


class Account extends Core\Controller {


    /**
     * Empty constructor to overwrite the needed arguments of the parent
     * TODO: add args to dockblock
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

        // Render the Views
        $view->render('header');
        $view->render('notifications');
        $view->render('account');
        $view->render('footer');
        exit;
    }


    public function logoutAction() {

        // Kill their current session
        $this->session->expireSession();

        // Redirect back to login
        header("HTTP/1.1 303 See Other");
        header("Location: " . SITE_ROOT . "login");
        exit;

    }


}