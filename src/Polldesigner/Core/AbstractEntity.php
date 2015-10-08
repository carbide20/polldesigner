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


abstract class AbstractEntity {


    /**
     * Handles setting entity properties, as long as they exist
     * @param $name
     * @param $value
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function __set($name, $value) {

        $field = "_" . strtolower($name);

        if (!property_exists($this, $field)) {
            throw new \InvalidArgumentException(
                "Setting the field '$field' is not valid for this entity.");
        }

        $mutator = "set" . ucfirst(strtolower($name));
        if (method_exists($this, $mutator) &&
            is_callable(array($this, $mutator))) {
            $this->$mutator($value);
        }
        else {
            $this->$field = $value;
        }

        return $this;

    }


    /**
     * Handles accessing properties, as long as they exist
     * @throws \InvalidArgumentException
     * TODO: Finish dockblock
     */
    public function __get($name) {
        $field = "_" . strtolower($name);

        if (!property_exists($this, $field)) {
            throw new \InvalidArgumentException(
                "Could not retrieve '$field', property not accessible.");
        }

        $accessor = "get" . ucfirst(strtolower($name));
        return (method_exists($this, $accessor) &&
                is_callable(array($this, $accessor))) ? $this->$accessor() : $this->field;
    }


    /**
     * Get all accessible properties of the entity
     * TODO: Finish dockblock
     */
    public function showProperties() {
        return get_object_vars($this);
    }


}