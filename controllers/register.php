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



class RegisterController extends Controller {


    /**
     * Renders the registration page
     */
    public function indexAction() {

        // Get a view object
        $view = new View($this);

        // Render the view
        $view->render('register');

    }


    /**
     * Handles the registration form
     */
    public function formAction() {

        // Grab the formdata
        $formdata = $this->getRequest();

        // Instantiate a validator with the formdata
        $validate = new Validate($formdata);

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

            $user = new UserModel($this->getDbh());
            $user->setUsername($formdata['username'])->setPassword($formdata['password']);
            $user = $user->load();

            // Check to see if the user already existed
            if ($user->getId()) {

                // TODO: Add an error to the session and redirect back to the register page
                die('Sorry, that username is already taken');

            // The user doesn't exist, so we're fine to save it
            } else {

                // Save the user with the new info to the DB
                $user->save();

            }


        }


    }


}