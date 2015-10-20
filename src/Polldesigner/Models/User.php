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


namespace Polldesigner\Models;

use \Polldesigner\Core as Core;


/**
 * Class UserModel - responsible for knowing of, setting, and getting its own properties
 * @package Model
 */
class User {

    public $table = 'users';
    public $id, $username, $password;
    public $loaded = false;

}