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


class Register extends Core\Controller {


    /**
     * Empty constructor to overwrite the needed arguments of the parent
     */
    public function __construct() {
    }


    /**
     * Renders the registration page
     */
    public function indexAction() {

        // Get a Views object
        $view = new Core\View($this);

        // Render the Views
        $view->render('register');

    }


    /**
     * Handles the registration form
     */
    public function formAction() {

        // Grab the formdata
        $formdata = $this->getRequest();

        // Instantiate a validator with the formdata
        $validate = new Core\Validate($formdata);

        // Make sure passwords match
        $validate->addRule('password', 'match', $formdata['password2'], "Your passwords must match.");

        // Run the validation rules, and retrieve any errors
        $errors = $validate->validate();

        // If we ran into a validation error
        if (count($errors) > 0) {

            // TODO: Add error to the session and redirect back to the register page
            foreach($errors as $error) {
                echo $error . '<br />';
            }

            die();

        // Good to go, no validation errors
        } else {

            echo 'Model: <pre>'; var_dump($this->getModel()); echo '</pre>';
            $user = $this->getModel()->factory('user');
            echo '<pre>'; var_dump($user); echo '</pre>';

//            $user->setUsername($formdata['username'])->setPassword($formdata['password']);
//            $user = $user->load();
//
//            // Check to see if the user already existed
//            if ($user->getId()) {
//
//                // TODO: Add an error to the session and redirect back to the register page
//                die('Sorry, that username is already taken');
//
//            // The user doesn't exist, so we're fine to save it
//            } else {
//
//                // Save the user with the new info to the DB
//                $user->save();
//
//            }


        }


    }


}