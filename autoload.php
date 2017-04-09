<?php
/**
 * Created by PhpStorm.
 * User: Adam
 * Date: 09.04.2017
 * Time: 19:23
 */

//Sets BASE_PATH to the name of the directory the file is in
define('BASE_PATH', realpath(dirname(__FILE__)));

// The vendor autoloading file
if (!file_exists(BASE_PATH . '/vendor/autoload.php')) {
    die('Please run `composer install` to generate your vendor directory');
}
require_once BASE_PATH . '/vendor/autoload.php';