<?php
define('URL_ROOT','http://localhost/');
define('APP_NAME', 'mvc');
define('ORG', 'UKC MB');

define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'mvc');

/*-----------------------------------*/

define('DB_DSN','mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE);
define('URL', URL_ROOT . APP_NAME . '/');
if(php_sapi_name() != 'cli') 
    define('USER_IP', $_SERVER['REMOTE_ADDR']);