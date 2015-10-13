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
            $dbh = new \PDO('mysql:host=' . $host . ';dbname=' . $db, $username, $password);
            $this->dbh = $dbh;
        } catch (PDOException $e) {
            // TODO: write the error message to a log: $e->getMessage();
        }
    }


    public function getHandle() {
        return $this->dbh ? $this->dbh : false;
    }


    /**
     * Functions as a wrapper for select queries
     *
     * @param $table - The table to select from
     * @param array $fields - The fields to select. This defaults to all fields.
     * @param array $bind - The required bindings in the form of array('property => 'value')
     * @param string $operator - This defaults to AND, but can be changed to OR. For more complex
     *     queries combining operators or using parenthesis to group operations, please use the custom
     *     SQL function instead.
     * @return bool - false if no results found | array - result rows mapped to an array
     */
    public function select($table, array $fields = array('*'), array $bind = array(), $operator = "AND") {

        // Look for properties to bind
        if ($bind) {

            $where = array();

            // Update the bindings to match the proper format
            foreach ($bind as $col => $value) {
                unset($bind[$col]);
                $bind[":" . $col] = $value;
                $where[] = $col . " = :" . $col;
            }
        }

        // Form the query. Pay attention, this one gets complicated ;)
        $sql = "SELECT " . (count($fields) > 1 ? implode(", ", $fields) : $fields[0]) . " FROM " . $table . (($bind) ? " WHERE " . implode(" " . $operator . " ", $where) : " ");

        // Prep, Execute, Fetch any existing rows and return
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($bind);
        $row = $stmt->fetch();

        return $row;

    }


    // TODO: add docblock
    public function insert($table, array $bind = array()) {

        // Ensure they have something to insert
        if (!$bind) { return false; }

        // Create the bind and values arrays
        foreach ($bind as $col => $value) {

            unset($bind[$col]);
            $bind[":" . $col] = $value;
            $values[] = $col;

        }

        // Form the query
        $sql = "INSERT INTO " . $table . " (" . implode(', ', $values) . ") VALUES (" . implode(', ', array_keys($bind)) . ")";

        // Prep, Execute, and see if the insertion was successful
        $stmt = $this->dbh->prepare($sql);
        return $stmt->execute($bind);

    }


    // TODO: add dockblock
    public function update($table, array $setBind = array(), $whereBind = array(), $operator = "AND") {

        // Ensure they have something to update
        if (!$setBind || !$whereBind) { return false; }

        // Create the bind array
        foreach ($setBind as $col => $value) {

            unset($setBind[$col]);
            $setBind[":" . $col] = $value;
            $set[] = $col . " = :" . $col;

        }

        // Update the bindings to match the proper format
        foreach ($whereBind as $col => $value) {

            unset($whereBind[$col]);
            $whereBind[":" . $col] = $value;
            $where[] = $col . " = :" . $col;

        }

        // Merge all the bindings
        $bind = array_merge($setBind, $whereBind);

        // Form the query.
        $sql = "UPDATE " . $table . " SET " . implode(", ", $set) . " WHERE " . implode(" " . $operator . " ", $where);

        // Prep, Execute, and return
        $stmt = $this->dbh->prepare($sql);
        return $stmt->execute($bind);

    }

}