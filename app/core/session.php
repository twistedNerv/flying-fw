<?php
class session {
    
    function __construct() {
        if(session_status() == PHP_SESSION_NONE)  
            session_start(); 
    }
    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }
    
    public function get($key) {
        if(isset($_SESSION[$key]))
            return $_SESSION[$key];
    }
    
    public function destroy() {
        unset($_SESSION);
        //session_destroy();
    }
}