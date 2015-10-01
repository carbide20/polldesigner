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


// TODO: remove this test
//$query = $dbh->prepare("SELECT * FROM users");
//$query->execute();
//$result = $query->fetch(PDO::FETCH_ASSOC);
//
//echo '<pre>'; echo var_dump($result); echo '</pre>';



// Parse the path
$url = explode('/', $_GET['path']);

// Instantiate a controller object, which will allow us to create other
//controllers via a factory function
$controller = new Controller();

// Instantiate a route object, which will allow us to try and match the
// route to a controller / action and execute it
$route = new Route($controller, $url);

// Try and call the route. If successful, we are done. Otherwise
// we'll throw a 404 page here
if (!$route->call()) {

    // TODO: Return a 404 page here
    echo 'Couldn\'t find the requested page.';

}