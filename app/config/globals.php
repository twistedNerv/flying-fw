<?php
require_once 'custom.php';

if ($mainSettings['DISPLAY_ERRORS']) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

define('URL_ROOT_LOCAL', $mainSettings['URL_ROOT_LOCAL']);
define('URL_ROOT_PUBLIC', $mainSettings['URL_ROOT_PUBLIC']);
define('APP_NAME', $mainSettings['APP_NAME']);
define('ORG', $mainSettings['ORGANIZATION']);
define('TEMPLATE', $mainSettings['TEMPLATE']);
define('TITLE', $mainSettings['TITLE']);
define('HEADER_TITLE', $mainSettings['HEADER_TITLE']);
define('DISPLAY_PAGE_HEADER', $mainSettings['DISPLAY_PAGE_HEADER']);
define('PUBLIC_SETTINGS', $mainSettings['PUBLIC_SETTINGS']);
define('DB_HOST', $mainSettings['DB_HOST']);
define('DB_USERNAME', $mainSettings['DB_USERNAME']);
define('DB_PASSWORD', $mainSettings['DB_PASSWORD']);
define('DB_DATABASE', $mainSettings['DB_DATABASE']);
define('DB_DSN','mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE);
define('LIMIT_LOGIN_ATTEMPTS', $mainSettings['LIMIT_LOGIN_ATTEMPTS']);
define('MAX_LOGIN_ATTEMPTS', $mainSettings['MAX_LOGIN_ATTEMPTS']);
define('LOGIN_PENALTY_DURATION', $mainSettings['LOGIN_PENALTY_DURATION']);

if(php_sapi_name() != 'cli') {
    define('USER_IP', $_SERVER['REMOTE_ADDR']);
    if($_SERVER['REMOTE_ADDR'] == "127.0.0.1" || $_SERVER['REMOTE_ADDR'] == "::1") {
        define('URL_ROOT', URL_ROOT_LOCAL);
        define('URL', URL_ROOT_LOCAL . APP_NAME . '/');
    } else {
        define('URL_ROOT', URL_ROOT_PUBLIC);
        define('URL', URL_ROOT_PUBLIC . APP_NAME . '/');
    }
}