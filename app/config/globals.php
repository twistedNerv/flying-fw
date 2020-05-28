<?php
define('DB_DSN','mysql:host=localhost;dbname=mvc');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'mvc');

define('URL','http://localhost/mvc/');
define('APP_NAME', 'mvc');
if(php_sapi_name() != 'cli') define('USER_IP', $_SERVER['REMOTE_ADDR']);