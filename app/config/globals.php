<?php
//MySQL localhost/CKO connection data
define('DB_DSN','mysql:host=localhost;dbname=mvc');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'mvc');

if(php_sapi_name() != 'cli')
    define('USER_IP', $_SERVER['REMOTE_ADDR']);
//if($_SERVER['REMOTE_ADDR'] == "::1") {
    define('URL','http://localhost:8080/mvc/');
/*} else {
    define('URL','http://10.20.124.226:8080/mvc/');
}*/