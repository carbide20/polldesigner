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



class IndexController extends Controller {


    /**
     * Empty constructor to overwrite the needed arguments of the parent
     */
    public function __construct() {

    }


    public function indexAction() {

        // Get a views object
        $view = new View($this);

        // Render the homepage views
        $view->render('home');


    }


}