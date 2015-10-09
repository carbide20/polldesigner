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


namespace Polldesigner\Core;


// The Views object's job is to find the right Views and include it
class View {


    private $controller;


    public function __construct($controller) {
        $this->controller = $controller;
    }


    public function getController() {
        return $this->controller;
    }

    // This allows a Views to easily render a template,
    // without having to provide the full path
    /**
     * Pulls in a template file if it exists, based on the route name for the file. Otherwise
     * it returns false.
     *
     * @param $template - The template name as parsed from a route, excluding directory / extension
     * @return bool - false when template not found
     */
    public function render($view = null) {

        // Check to make sure the template exists
        if (file_exists('../src/Polldesigner/Views/' . ucfirst($view) . '.php')) {

            // Load up the template
            require_once('../src/Polldesigner/Views/' . ucfirst($view) . '.php');
            return true;

        // The requested template file doesn't exist
        } else {

            return false;

        }

    }
}