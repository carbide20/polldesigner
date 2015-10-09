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


class Register extends Core\Controller {


    /**
     * Empty constructor to overwrite the needed arguments of the parent
     * TODO: add args to dockblock
     */
    public function __construct(\PDO $dbh, $request) {
        parent::__construct($dbh, $request);
    }


    /**
     * Renders the registration page
     */
    public function indexAction() {

        // Get a Views object
        $view = new Core\View($this);

        // Render the Views
        $view->render('header');
        $view->render('notifications');
        $view->render('register');
        $view->render('footer');
        exit;
    }


    /**
     * Handles the registration form
     * TODO: Consider whether or not to move the form validation logic into UserMapper->register()
     */
    public function formAction() {

        // Grab the formdata
        $formdata = $this->getRequest();

        // Validate the form
        if (new Core\Validators\RegisterValidate($formdata)) {

            // Create a new user mapper
            $userMapper = new Models\UserMapper($this->dbh);

            // Register the user with the postdata
            if ($userMapper->register($_POST)) {

                // TODO:
                // Log them in and send them to their account page
                // with a welcome message in the session

            } else {

                // Redirect back, so the errors can be displayed
                header("HTTP/1.1 303 See Other");
                header("Location: register");
                exit;

            }

        // Failed to validate
        } else {

            // Redirect back, so the errors can be displayed
            header("HTTP/1.1 303 See Other");
            header("Location: register");
            exit;

        }


    }


}