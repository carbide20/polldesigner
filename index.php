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


// This is where we load up most of the other required files
// for the project, read config data, and initialize things
require_once 'bootstrap.php';

// Parse the URL path requested
if (array_key_exists('path', $_GET)) {
    $url = explode('/', $_GET['path']);
} else {
    $url = array('index');
}

// Instantiate a controller object, which will allow us to create other
//controllers via a factory function
$controller = new Controller($_REQUEST);

// Instantiate a route object, which will allow us to try and match the
// route to a controller / action and execute it
$route = new Route($controller, $url);

// Call the route
$route->call();