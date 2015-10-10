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


/**
 * This is the core data mapper, from which other data mappers extend.
 * It provides wrapper functionality for more common SQL commands,
 * to abstract most handwritten SQL away from the child data mappers.
 * This served to keep them simpler, but also to normalize error handling
 * and make switching to a different DB easier.
 *
 * Class DataMapper
 * @package Core
 */
class DataMapper {

    protected $dbh;


    /**
     *
     * @param $dbh - database handle
     */
    public function __construct(\PDO $dbh) {
        $this->dbh = $dbh;
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
        $sql = "SELECT " . count($fields) > 1 ? implode(", ", $fields) : $fields[0] . " FROM " . $table . (($bind) ? " WHERE " . implode(" " . $operator . " ", $where) : " ");

        // Prep, Execute, Fetch any existing rows and return
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($bind);
        $row = $stmt->fetch();

        return $row;

    }


    public function insert($table, array $bind = array()) {

        // Ensure they have something to insert
        if (!$bind) { return false; }

        foreach ($bind as $col => $value) {
            unset($bind[$col]);
            $bind[":" . $col] = $value;
            $values[] = $col;
        }

        // Form the query
        $sql = "INSERT INTO " . $table . " (" . implode(', ', $values) . ") VALUES (" . implode(', ', array_keys($bind)) . ")";

        // Prep, Execute, and see if the insertion was successful
        $stmt = $this->dbh->prepare($sql);
        return ($stmt->execute($bind));

    }

}