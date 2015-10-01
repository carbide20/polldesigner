<?php
/**
 * @Project: Poll designer
 * @Author: Dan Hennion
 * @Date: 09/30/2015
 * @Purpose: This project is designed to serve as a sample
 *  of my code. As such, it is not built on any existing framework
 *  and 100% of the code is my own.
 */


class Route {


    private $controller, $route, $targetController;


    public function __construct($controller, $route) {

        $this->controller = $controller;
        $this->route = $route;

    }

    public function call() {

        // Save the target controller or false if not found to a property, and then call
        // it if we do have it
        if ( $this->targetController = $this->controller->factory($this->route[0]) ) {

            return $this->getAction();

        // Otherwise the factory couldn't create the controller. Return false
        } else {

            return false;

        }

    }

    /**
     * This function should only be called from a context in which $this->targetController
     * is an actual controller object and not false, otherwise it will fail.
     *
     * @return bool
     */
    private function getAction() {

        if (array_key_exists(1, $this->route)) {

            // check if the method exists
            // if not, return 'index'
            if (method_exists($this->targetController, $this->route[1])) {

                // The route called yields a method, call it
                $this->targetController->this->route[1];

                // Successful response
                return true;

            }

        } else if (method_exists($this->targetController, 'index')) {

            // Call the index method
            $this->targetController->index();

            // Successful response
            return true;

        } else {

            // We found no method to call at this route. Return false so a 404 page can
            // be displayed, or some other way of handling this
            return false;

        }

    }

}