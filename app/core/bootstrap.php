<?php

class bootstrap {
    
    protected $controller = 'homeController';
    protected $method = 'indexAction';
    protected $params = [];
    protected $contentPath = "content/";

    public function __construct() {
        $url = $this->parseUrl();
        if(file_exists('app/controllers/' . $url[0] . 'Controller.php')) {
            $this->controller = $url[0] . "Controller";
            $this->contentPath = "";
        } 
        if(file_exists('app/content/controllers/' . $url[0] . 'Controller.php')) {
            if (!$this->contentPath) {
                die("Err: Controller class redefinition.");
            }
            $this->controller = $url[0] . "Controller";
        }
        unset($url[0]);
        require_once 'app/' . $this->contentPath . 'controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;
        
        if(isset($url[1])) {
            if(method_exists($this->controller, $url[1]."Action")) {
                $this->method = $url[1]."Action";
                unset($url[1]);
            }
        }
        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->params);
    }
    
    public function parseUrl() {
        if(isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return null;
    }
    
}