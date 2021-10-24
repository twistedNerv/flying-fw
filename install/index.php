<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

class installer {

    public function run() {
        if ($this->tools->getPost('action') == 'install_start') {
            $url_root_local = $this->tools->getPost('url_root_local');
            $url_root_public= $this->tools->getPost('url_root_public');
            $app_name       = $this->tools->getPost('app_name');
            $template       = $this->tools->getPost('template');
            $organization   = $this->tools->getPost('organization');
            $title          = $this->tools->getPost('title');
            $header_title   = $this->tools->getPost('header_title');
            
            $create_config  = $this->tools->getPost('create_config');
            $create_db      = $this->tools->getPost('create_db');
            $create_tables  = $this->tools->getPost('create_tables');
            
            $db_host        = $this->tools->getPost('db_host');
            $db_username    = $this->tools->getPost('db_username');
            $db_password    = $this->tools->getPost('db_password');
            $db_database    = $this->tools->getPost('db_database');
            
            $display_errors = $this->tools->getPost('display_errors');
            $display_page_header = $this->tools->getPost('display_page_header');
if ($create_config) {
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
    'DISPLAY_PAGE_HEADER' => " . $display_page_header . "
];";
            file_put_contents('../app/config/custom.php', $custom_file);
            exec('chown root:root ../app/config/custom.php');
            exec('chmod 777 ../app/config/custom.php');
}
            if ($create_db || $create_tables) {
                
                if ($create_db) {
                    try {
                        $dbh = new PDO("mysql:host=$db_host", $db_username, $db_password);
                        $dbh->exec("CREATE DATABASE IF NOT EXISTS `$db_database`;");
                    } catch (PDOException $e) {
                        die("DB Error: " . $e->getMessage());
                    }
                }
                if ($create_tables) {
                    try {
                        $pdo = new PDO("mysql:dbname=$db_database;host=$db_host", $db_username, $db_password);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        
                        $path = '../app/dbschemas/';
                        $files = scandir($path);
                        if (isset($files[0]) && $files[0] == "." && isset($files[1]) && $files[1] == ".." ) {
                            unset($files[0]); unset($files[1]);
                        }
                        foreach ($files as $file) {
                            $sql = file_get_contents("../app/dbschemas/" . $file);
                            $pdo->exec($sql);
                        }
                    } catch (PDOException $e) {
                        die("DB Error: " . $e->getMessage());
                    }
                }
            }
            echo "<meta http-equiv='refresh' content='5; url=" . $url_root_local . $app_name . "' />";
            echo "Installation finished. You will be redirected to main page in a few moments.<br><br>"
            . "In case it doesn't redirect automatically, click here: <a href='" . $url_root_local . $app_name . "'>Local</a>";
        } else {
            require_once 'form.php';
        }
    }
}

$obj = new installer();
$obj->run();