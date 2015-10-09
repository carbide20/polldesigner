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
// SESSION
//////////////////////////////////////////////////////////
session_start();


//////////////////////////////////////////////////////////
// CONSTANT DEFITIONS
//////////////////////////////////////////////////////////

    define( 'ROOTPATH', dirname(dirname(dirname(__DIR__))) );


//////////////////////////////////////////////////////////
// REQUIRED FILES
//////////////////////////////////////////////////////////

    // This files is all someone should have to change to make the app work
    require_once ROOTPATH . '/src/Polldesigner/Core/Config.php';

    // Composer autoload
    require_once ROOTPATH . "/vendor/autoload.php";


//////////////////////////////////////////////////////////
// NAMESPACES
//////////////////////////////////////////////////////////

    use Polldesigner\Core as Core;
    use Polldesigner\Controllers as Controllers;
    use Polldesigner\Models as Models;
    use Polldesigner\Views as Views;

//////////////////////////////////////////////////////////
// INITIALIZATIONS
//////////////////////////////////////////////////////////

    // Create a connection to the database, by passing the credentials in from
    // Config.php
    $database = new Core\Database(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);

    // Get a handle for the database
    $dbh = $database->getHandle();


    // Parse the URL path requested
    if (array_key_exists('path', $_GET)) {
        $url = explode('/', $_GET['path']);
    } else {
        $url = array('index');
    }

    // Instantiate a controller object, which will allow us to create other
    //Controllers via a factory function
    $controller = new Core\Controller($dbh, $_REQUEST);

    // Instantiate a route object, which will allow us to try and match the
    // route to a controller / action and execute it
    $route = new Core\Route($controller, $url);

    // Call the route
    $route->call();