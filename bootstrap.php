<?php
/**
 * @Project: Poll designer
 * @Author: Dan Hennion
 * @Date: 09/30/2015
 * @Purpose: This project is designed to serve as a sample
 *  of my code. As such, it is not built on any existing framework
 *  and 100% of the code is my own. The app is designed with my interpretation of MVC
 */


//////////////////////////////////////////////////////////
// REQUIRED FILES
//////////////////////////////////////////////////////////

    // This files is all someone should have to change to make the app work
    require_once 'config.php';

    // This is a list of the folders with contents that need to be required
    $folders = array('core', 'controller', 'model');

    // Loop through every folder that we have defined, and require
    // every file.
    // TODO: Add additional checking to match only .php files, just in case
    foreach($folders as $folder) {
        foreach (new DirectoryIterator($folder) as $file) {
            if ($file != '.' && $file != '..') {
                require_once($folder . '/' . $file);
            }
        }
    }

//////////////////////////////////////////////////////////
// INITIALIZATIONS
//////////////////////////////////////////////////////////

    // Create a connection to the database, by passing the credentials in from
    // config.php
    $database = new Database(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);

    // Get a handle for the database
    $dbh = $database->getHandle();
