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
 * This class is going to act as a data mapper pattern ORM. It will be
 * responsible for bridging the gap between our domain Models and our
 * persistence layer (the database, here)
 * TODO: Write the class!
 * Class DataMapper
 * @package Core
 */
class DataMapper {

    private $dbh;


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
     * @param array $bind - The required bindings in the form of array('property => 'value')
     * @param string $operator - This defaults to AND, but can be changed to OR. For more complex
     *     queries combining operators or using parenthesis to group operations, please use the custom
     *     SQL function instead.
     * @return bool - false if no results found | array - result rows mapped to an array
     */
    public function select($table, array $bind = array(),
                           $operator = "AND") {

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

        // Form the query
        $sql = "SELECT * FROM " . $table . (($bind) ? " WHERE " . implode(" " . $operator . " ", $where) : " ");

        // Prep, Execute, Fetch any existing rows and return
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($bind);
        $row = $stmt->fetch();

        return $row;

    }

}