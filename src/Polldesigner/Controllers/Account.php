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


namespace Polldesigner\Controllers;

use Polldesigner\Core as Core;
use Polldesigner\Models as Models;


class Account extends Core\Controller {


    /**
     * Empty constructor to overwrite the needed arguments of the parent
     * TODO: add args to dockblock
     */
    public function __construct(\PDO $dbh, $request) {
        parent::__construct($dbh, $request);
    }


    /**
     * Renders the registration page
     */
    public function indexAction() {

        // Get a Views object
        $view = new Core\View($this);

        // Render the Views
        $view->render('header');
        $view->render('notifications');
        $view->render('account');
        $view->render('footer');
        exit;
    }


}