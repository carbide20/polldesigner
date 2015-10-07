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


    // Private properties
    private $dbh, $model, $request;


    /**
     * Takes any request parameters passed to the page, and sets them to a property
     * for reference
     *
     * @param $dbh - database handler
     * @param $model - the core model is required so our controller can interact with model
     * @param $request - Any request parameters
     */
    public function __construct(PDO $dbh, $request) {

        $this->model = $model;
        $this->dbh = $dbh;
        $this->request = $request;

    }


    /**
     * Gets any request parameters that were passed to the page
     *
     * @return mixed - array of any request parameters, if any; null if not
     */
    public function getRequest() {
        return $this->request;
    }


    public function getModel() {
        return $this->model;
    }


    public function getDbh() {
        return $this->dbh;
    }


    /**
     * Factory pattern for instantiating controllers
     * @param $controller - The name of the controller, without path or extension
     * @return object - The new controller | bool - false on failure
     */
    public function factory($controller) {

        // Fall back to the index controller if none was requested
        if ($controller == '') { $controller = 'index'; }

        // See if we can match this to a real controller
       if (class_exists(ucfirst($controller) . 'Controller')) {

           // Build the class name from the request
           $class = ucfirst($controller) . 'Controller';
           echo $class;

           // Instantiate the new controller class, passing it the request, and return it
           return new $class();

       // Couldn't find another controller to handle it, use this one
       } else {
           return false;
       }

    }


}