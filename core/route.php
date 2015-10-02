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

// The route object's job is to take routes, find the right controller, and call the right action,
// Passing along any optional arguments for use within the controller action
class Route {

    // Private property definition
    private $controller, $route, $targetController;

    /**
     * Upon instantiation, the constructor sets our main two class properties,
     * with which we will instantiate and call the proper controller / method
     *
     * @param $controller - Takes the main controller object, through which we will
     *                      instantiate other objects
     * @param $route -      This is an array of route data, broken down into:
     *                      [0] - controller
     *                      [1] - (optional) action. We will use indexAction if not defined
     *                      [2] through [infinity] are parameters that can be used by the controller
     */
    public function __construct($controller, $route) {

        $this->controller = $controller;
        $this->route = $route;

    }


    /**
     * This function should only be called from a context in which $this->targetController
     * is an actual controller object and not false, otherwise it will fail.
     *
     * @return bool
     */
    public function call()
    {

        // Pass the route to the factory to see if it can find us a controller to use
        $this->targetController = $this->controller->factory($this->route[0]);

        // Try and use the controller factory to instantiate the controller the route indicates
        if ($this->targetController != false) {

            // If there is no action, or there's an empty action, we'll try and use indexAction
            if (!array_key_exists(1, $this->route) || (array_key_exists(1, $this->route) && $this->route[1] == '')) {
                $this->route[1] = 'index';
            }


            if (method_exists($this->targetController, $action = $this->route[1] . 'Action')) {

                // The route called yields a method, call it
                $this->targetController->$action();

                // Successful response
                return true;

                // They didn't want to call an action, so let's check for the default indexAction
            } else if (method_exists($this->targetController, 'indexAction')) {

                // Call the index method
                $this->targetController->indexAction();

                // Successful response
                return true;

                // Couldn't find any action to call. Give 'em the bad news
            } else {

                // We found no method to call at this route. Return a 404 page
                // TODO: add a better 404 page here
                header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
                echo "404 - Couldn't find the requested page. <br />";

            }

            // The factory has no idea what controller the route is talking about. Give 'em the bad news
        } else {

            // TODO: add a better 404 page here
            header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
            echo "404 - Couldn't find the requested page. <br />";

        }
    }

}