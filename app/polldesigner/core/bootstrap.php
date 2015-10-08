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


//////////////////////////////////////////////////////////
// CONSTANT DEFITIONS
//////////////////////////////////////////////////////////

    define( 'ROOTPATH', dirname(dirname(dirname(__DIR__))) );



//////////////////////////////////////////////////////////
// REQUIRED FILES
//////////////////////////////////////////////////////////

    // This files is all someone should have to change to make the app work
    require_once ROOTPATH . '/app/polldesigner/core/config.php';

    // Composer autoload
    require_once ROOTPATH . "/vendor/autoload.php";


//////////////////////////////////////////////////////////
// NAMESPACES
//////////////////////////////////////////////////////////

    use polldesigner\core as core;
    use polldesigner\controllers as controllers;
    use polldesigner\models as models;
    use polldesigner\views as views;

//////////////////////////////////////////////////////////
// INITIALIZATIONS
//////////////////////////////////////////////////////////

    // Create a connection to the database, by passing the credentials in from
    // config.php
    $database = new core\Database(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);

    // Get a handle for the database
    $dbh = $database->getHandle();


    // Parse the URL path requested
    if (array_key_exists('path', $_GET)) {
        $url = explode('/', $_GET['path']);
    } else {
        $url = array('index');
    }

    // Instantiate a controller object, which will allow us to create other
    //controllers via a factory function
    $controller = new core\Controller($dbh, $_REQUEST);

    // Instantiate a route object, which will allow us to try and match the
    // route to a controller / action and execute it
    $route = new core\Route($controller, $url);

    // Call the route
    $route->call();