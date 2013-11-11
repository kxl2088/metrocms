<?php
// Errors on full!
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);
require 'goutte.phar';
/**
* Travis doesn't give access to local socket (localhost), so this is a 
* quick switch to run the tests locally, 127.0.0.1 should run on travis
* and localhost should run locally (depending on your config)
**/
define('METRO_DB_HOST',isset($_SERVER['METRO_DB_HOST']) ? $_SERVER['METRO_DB_HOST'] : 'localhost');
define('METRO_HOST', isset($_SERVER['METRO_TEST_HOST']) ? $_SERVER['METRO_TEST_HOST'] : 'localhost');
