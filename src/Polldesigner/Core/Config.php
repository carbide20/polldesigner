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
// PLEASE NOTE!
// This config file needs to be hidden from the public
// To keep your credentials safe. Please CHMOD this file
// to 644 permissions on public servers
//////////////////////////////////////////////////////////

// TODO: Most of these except the DB credentials should be
// stored in the DB, and this converted into an object.

// Database info / credentials
define('DB_HOST', "localhost");
define('DB_DATABASE', "Polldesigner");
define('DB_USER', "root");
define('DB_PASSWORD', "");

// Site root
define('SITE_ROOT', "http://localhost/polldesigner/");

// Page to redirect to after user times out
define('TIMEOUT_PAGE', "login/index");

// amount of time before page timeout, measured in minutes
define('TIMEOUT_TIME', 60);