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


class Database {

    private $dbh;


    /**
     * Establishes a connection to our Database, and returns a PDO object on success
     * or an error string on false.
     *
     * @param $host - database hostname
     * @param $db - which database to use
     * @param $username - username for DB access
     * @param $password - password for DB access
     * @return PDO - database connection returned on success | string - error string
     *         returned on false.
     */
    public function __construct($host, $db, $username, $password)
    {
        try {
            $dbh = new PDO('mysql:host=' . $host . ';dbname=' . $db, $username, $password);
            $this->dbh = $dbh;
        } catch (PDOException $e) {
            // TODO: write the error message to a log: $e->getMessage();
        }
    }

    public function getHandle() {
        return $this->dbh ? $this->dbh : false;
    }

}