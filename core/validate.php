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

// Use the validate object to run validation rules on formdata, and return errors
class Validate {


    // Private properties
    private $formdata;
    private $rules;


    /**
     * Set the formdata to a property so we can use it when we run validate()
     * @param $formdata - array of data from the form
     */
    public function __construct($formdata) {
        $this->formdata = $formdata;
    }

    /**
     * Lets validation rules be added for processing form data
     *
     * @param $input - The name of the form input
     * @param $ruleType - One of the rule validation types defined in this class
     * @param $ruleSetting - Additional settings the validation rule may need
     * @param $errorMessage - The error to throw if we fail validation on this rule
     */
    public function addRule($input, $ruleType, $ruleSetting, $errorMessage) {

        // Save the rule
        $this->rules[] = array('input' => $input,
                               'ruleType' => $ruleType,
                               'ruleSetting' => $ruleSetting,
                               'errorMessage' => $errorMessage);

    }


    /**
     * Runs through all the validation rules, collects the errors in an array, and returns it
     * @return array - errors from validation
     */
    public function validate() {

        // Keep track of any errors we run into
        $errors = array();

        // Loop through each of the validation rules
        foreach($this->rules as $rule) {

            // Check to see if the referenced input exists in the formdata
            if (array_key_exists($rule['input'], $this->formdata)) {

                // Check to see if we have a function for this rule type, and call it
                if (method_exists($this, $rule['ruleType'])) {

                    // Run our rule, and add the error if it fails
                    if (!$this->$rule['ruleType']($this->formdata[$rule['input']], $rule['ruleSetting']) ) {

                        $errors[] = $rule['errorMessage'];

                    }

                } else {
                    // TODO: add some logging here to help developers
                }

            } else {
                // TODO: add some logging here to help developers
            }

        }

        // Send back the errors
        return $errors;

    }


    /**
     * Compares two form inputs to see if they match
     *
     * @param $first - A form input
     * @param $second - Another form input
     * @return bool - Whether they match
     */
    private function match($first, $second) {
        return ($first == $second);
    }



}