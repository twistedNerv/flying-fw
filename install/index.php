<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

class installer {

    public function run() {
        if (isset ($_POST['action']) && $_POST['action'] == 'install_start') {
            $url_root_local = $this->getPost('url_root_local');
            $url_root_public= $this->getPost('url_root_public');
            $app_name       = $this->getPost('app_name');
            $template       = $this->getPost('template');
            $organization   = $this->getPost('organization');
            $title          = $this->getPost('title');
            $header_title   = $this->getPost('header_title');
            
            $create_config  = (isset($_POST['create_config'])) ? $_POST['create_config'] : false;
            $create_db      = (isset($_POST['create_db'])) ? $_POST['create_db'] : false;
            $create_tables  = (isset($_POST['create_tables'])) ? $_POST['create_tables'] : false;
            
            $db_host        = $this->getPost('db_host');
            $db_username    = $this->getPost('db_username');
            $db_password    = (isset($_POST['db_password'])) ? $_POST['db_password'] : "";
            $db_database    = $this->getPost('db_database');
            
            $display_errors = $this->getPost('display_errors');
            $display_page_header = $this->getPost('display_page_header');
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
    
    private function getPost($post_var) {
        if (isset($_POST[$post_var]) && $_POST[$post_var] != "") {
            return $_POST[$post_var];
        } else {
            echo "POST or it's value missing: " . $post_var . "<br>";
            die;
        }
    }
}

$obj = new installer();
$obj->run();