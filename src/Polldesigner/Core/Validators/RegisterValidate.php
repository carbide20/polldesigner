<?php

namespace Polldesigner\Core\Validators;


class RegisterValidate extends Validate {


    public function __construct($formdata) {

        // Make sure passwords match
        $this->addRule('password', 'match', $formdata['password2'], "Your passwords must match.");

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