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

        // Testing
        echo '<pre>'; var_dump($errors); echo '</pre>';

//        $user = new User();
//        $user->register();


    }


}