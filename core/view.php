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


class View {

    // This allows a view to easily render a template,
    // without having to provide the full path
    public function render($template) {

        // Check to make sure the template exists
        if (file_exists('templates/' . $template . '.php')) {

            // Load up the template
            require_once('templates/' . $template . '.php');

        // The requested template file doesn't exist
        } else {
            // TODO: add a message to the session here about not being able to locate the page
            return false;
        }

    }
}