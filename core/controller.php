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


class Controller {

    public function renderView($view = null) {

        // Require the matching view, if it exists
        if (file_exists($viewFile = 'views/' . $view . '.php')) {
            require_once($viewFile);
        }

    }

    /**
     * Factory pattern for instantiating controllers
     * @param $controller
     * @return bool|string
     */
    public function factory($controller) {

        // See if we can match this to a real controller
       if (class_exists(ucfirst($controller) . 'Controller')) {

           // Build the class name from the request, and then intstantiate and return
           $class = ucfirst($controller) . 'Controller';
           return new $class;

       // Couldn't find a real controller, return false
       } else {
           return false;
       }

    }

}