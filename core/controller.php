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


// The controller object's job is to help instantiate other controllers,
// and to provide common functionality among them by being extended by all controllers
class Controller {


    /**
     * Factory pattern for instantiating controllers
     * @param $controller - The name of the controller, without path or extension
     * @return object - The new controller | bool - false on failure
     */
    public function factory($controller) {

        // See if we can match this to a real controller
       if (class_exists(ucfirst($controller) . 'Controller')) {

           // Build the class name from the request, and then instantiate and return
           $class = ucfirst($controller) . 'Controller';
           return new $class;

       // Couldn't find a real controller, return false
       } else {
           return false;
       }

    }

}