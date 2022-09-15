<?php
session_start(); 
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once '../app/config/custom.php';
class installer {

    public function run() {
        if ($this->getPost('action') == 'install_start') {
            $url_root_local         = $this->getPost('url_root_local');
            $url_root_public        = $this->getPost('url_root_public');
            $app_name               = $this->getPost('app_name');
            $template               = $this->getPost('template');
            $organization           = $this->getPost('organization');
            $title                  = $this->getPost('title');
            $header_title           = $this->getPost('header_title');
            
            $create_config          = $this->getPost('create_config');
            $create_db              = $this->getPost('create_db');
            $create_tables          = $this->getPost('create_tables');
            
            $db_host                = $this->getPost('db_host');
            $db_username            = $this->getPost('db_username');
            $db_password            = $this->getPost('db_password');
            $db_database            = $this->getPost('db_database');
            
            $display_errors         = $this->getPost('display_errors');
            $display_page_header    = $this->getPost('display_page_header');
            $public_settings        = $this->getPost('public_settings');
            
            $limit_login_attempts   = $this->getPost('limit_login_attempts');
            $max_login_attempts     = $this->getPost('max_login_attempts');
            $login_penalty_duration = $this->getPost('login_penalty_duration');
            
if ($create_config != "false") {
$custom_file = "<?php
$" . "mainSettings = [
    //general
    'URL_ROOT_LOCAL' => '" . $url_root_local . "',
    'URL_ROOT_PUBLIC' => '" . $url_root_public . "',
    'APP_NAME' => '" . $app_name . "',
    'TEMPLATE' => '" . $template . "',
    'ORGANIZATION' => '" . $organization . "',
    'TITLE' => '" . $title . "',
    'HEADER_TITLE' => '" . $header_title . "',
    //MySql
    'DB_HOST' => '" . $db_host . "',
    'DB_USERNAME' => '" . $db_username . "',
    'DB_PASSWORD' => '" . $db_password . "',
    'DB_DATABASE' => '" . $db_database . "',
    //options
    'DISPLAY_ERRORS' => " . $display_errors . ",
    'DISPLAY_PAGE_HEADER' => " . $display_page_header . ",
    'PUBLIC_SETTINGS' => " . $public_settings . ",
    'LIMIT_LOGIN_ATTEMPTS' => " . $limit_login_attempts . ",
    'MAX_LOGIN_ATTEMPTS' => " . $max_login_attempts . ",
    'LOGIN_PENALTY_DURATION' => " . $login_penalty_duration . "
];";
            file_put_contents('../app/config/custom.php', $custom_file);
            exec('chown root:root ../app/config/custom.php');
            exec('chmod 777 ../app/config/custom.php');
}

            if ($create_db != "false") {
                try {
                    $dbh = new PDO("mysql:host=$db_host", $db_username, $db_password);
                    $dbh->exec("CREATE DATABASE IF NOT EXISTS `$db_database`;");
                } catch (PDOException $e) {
                    die("DB Error: " . $e->getMessage());
                }
            }
            if ($create_tables != "false") {
                try {
                    $pdo = new PDO("mysql:dbname=$db_database;host=$db_host", $db_username, $db_password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $path = '../app/dbschemas/';
                    $files = scandir($path);
                    if (isset($files[0]) && $files[0] == "." && isset($files[1]) && $files[1] == ".." ) {
                        unset($files[0]); 
                        unset($files[1]);
                    }
                    foreach ($files as $file) {
                        $table_name = str_replace(".sql", "", $file);
                        $sql = "SHOW TABLES LIKE '" . $table_name . "';";
                        $table_desc = $pdo->query($sql)->rowCount();
                        if ($table_desc < 1) {
                            $sql = file_get_contents("../app/dbschemas/" . $file);
                            $pdo->exec($sql);
                        }
                    }
                } catch (PDOException $e) {
                    die("DB Error: " . $e->getMessage());
                }
            }
            echo "<meta http-equiv='refresh' content='4; url=" . $url_root_local . $app_name . "' />";
            echo "Installation finished. You will be redirected to main page in a few moments.<br><br>"
            . "In case it doesn't redirect automatically, click here: <a href='" . $url_root_local . $app_name . "'>Local</a>";
        } else {
            require '../app/config/custom.php';
            require_once 'form.php';
        }
    }
    
    public function getPost($post_name) {
        $result = (isset($_POST[$post_name]) && $_POST[$post_name] != "") ? filter_var($_POST[$post_name], FILTER_SANITIZE_STRING) : "";
        return $result;
    }
}
//var_dump($_SESSION[$mainSettings['APP_NAME'] . '_activeUser']);
if ($mainSettings['PUBLIC_SETTINGS'] || (isset($_SESSION[$mainSettings['APP_NAME'] . '_activeUser']) && $_SESSION[$mainSettings['APP_NAME'] . '_activeUser']['level'] == 5)) {
    $obj = new installer();
    $obj->run();
} else {
    echo "<meta http-equiv='refresh' content='2; url=../user/login' />";
    echo "Not permited!";
}