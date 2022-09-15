<?php
class session {
    
    function __construct() {
        if(session_status() == PHP_SESSION_NONE) {
            session_start(); 
        }
    }
    public function set($key, $value) {
        $_SESSION[APP_NAME . "_" . $key] = $value;
    }
    
    public function get($key) {
        if(isset($_SESSION[APP_NAME . "_" . $key]))
            return $_SESSION[APP_NAME . "_" . $key];
    }
    
    public function destroy() {
        unset($_SESSION);
    }
}