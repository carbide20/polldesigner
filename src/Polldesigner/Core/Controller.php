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


// The controller object's job is to help instantiate other Controllers,
// and to provide common functionality among them by being extended by all Controllers
class Controller {


    // Private properties
    protected $database, $session, $request;


    /**
     * Takes any request parameters passed to the page, and sets them to a property
     * for reference
     *
     * @param $database - Database instance
     * @param $session - Session instance
     * @param $request - Any request parameters
     */
    public function __construct(Database $database, Session $session, $request) {

        $this->database = $database;
        $this->session = $session;
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



    public function getDatabase() {
        return $this->database;
    }


    /**
     * Factory pattern for instantiating Controllers
     * @param $controller - The name of the controller, without path or extension
     * @return object - The new controller | bool - false on failure
     */
    public function factory($controller) {

        // Fall back to the index controller if none was requested
        if ($controller == '') { $controller = 'index'; }

        // See if we can match this to a real controller
       if (class_exists('Polldesigner\Controllers\\' . ucfirst($controller) )) {

           // Build the class name from the request
           $class = 'Polldesigner\Controllers\\' . ucfirst($controller);

           // Instantiate the new controller class passing it the database, session, request; return it
           return new $class($this->database, $this->session, $this->request);

       // Couldn't find another controller to handle it, use this one
       } else {
           return false;
       }

    }


}