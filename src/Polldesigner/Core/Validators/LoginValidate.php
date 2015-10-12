<?php

namespace Polldesigner\Core\Validators;


class LoginValidate extends Validate {


    public function __construct($formdata) {

        // Make sure they entered something
        $this->addRule('password', 'min', 1, "Please enter your credentials to log in");
        $this->addRule('username', 'min', 1, "Please enter your credentials to log in");

        // Run the validation rules, and retrieve any errors
        $errors = $this->validate();

        // If we ran into a validation error
        if (count($errors) > 0) {

            // Loop through the errors, add them to the session, and then return false
            foreach ($errors as $error) {

                $_SESSION['errors'][] = $error;

            }

            return false;

            // Good to go, no validation errors
        } else {

            return true;

        }

    }


}