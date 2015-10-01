<?php
/**
 * @Project: Poll designer
 * @Author: Dan Hennion
 * @Date: 09/30/2015
 * @Purpose: This project is designed to serve as a sample
 *  of my code. As such, it is not built on any existing framework
 *  and 100% of the code is my own.
 */


// This is where we load up most of the other required files
// for the project, read config data, and initialize things
require_once 'bootstrap.php';

// TODO: remove this test
//$query = $dbh->prepare("SELECT * FROM users");
//$query->execute();
//$result = $query->fetch(PDO::FETCH_ASSOC);
//
//echo '<pre>'; echo var_dump($result); echo '</pre>';


echo '<pre>'; var_dump($_GET['path']); echo '</pre>';

$url = explode('/', $_GET['path']);
echo '<pre>'; var_dump($url); echo '</pre>';