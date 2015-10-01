<?php
/**
 * @Project: Poll designer
 * @Author: Dan Hennion
 * @Date: 09/30/2015
 * @Purpose: This project is designed to serve as a sample
 *  of my code. As such, it is not built on any existing framework
 *  and 100% of the code is my own.
 */


//////////////////////////////////////////////////////////
// REQUIRED FILES
//////////////////////////////////////////////////////////

    // This is all someone should have to change to make the app work
    require_once 'config.php';

    // This allows us to connect to the database, via PDO.
    require_once 'models/database.php';

    // The user model lets users create and manage accounts.
    // Polls are tied to users.
    require_once 'models/user.php';

    // This class allows users to create and publish polls
    // and collect results
    require_once 'models/poll.php';


//////////////////////////////////////////////////////////
// INITIALIZATIONS
//////////////////////////////////////////////////////////

    // Create a connection to the database, by passing the credentials in from
    // config.php
    $database = new Database(DB_HOST, DB_DATABASE, DB_USER, DB_PASSWORD);

    // Get a handle for the database
    $dbh = $database->getHandle();
