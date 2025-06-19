<?php
#[AllowDynamicProperties]
class controller {

    public function __construct() {
        $this->model = new model();
        $this->view = new view();
        $this->session = new session();
        $this->config = new config;
        $this->tools = new tools;
        $this->checkUserMembershipSite();
    }

    public function loadModel($model) {
        $contentPath = 'content/';
        if (file_exists('app/models/' . strtolower($model) . 'Model.php')) {
            $contentPath = '';
        }
        if (!$contentPath && file_exists('app/content/models/' . strtolower($model) . 'Model.php')) {
            die("Err: Model class redefinition");
        }
        require_once 'app/' . $contentPath . 'models/' . strtolower($model) . 'Model.php';
        $modelName = $model . 'Model';
        return new $modelName();
    }
    
    public function loadController($controller) {
        $contentPath = 'content/';
        if (file_exists('app/controllers/' . strtolower($controller) . 'Controller.php')) {
            $contentPath = '';
        }
        if (!$contentPath && file_exists('app/content/controller/' . strtolower($controller) . 'Controller.php')) {
            die("Err: Controller class redefinition");
        }
        require_once 'app/' . $contentPath . 'controllers/' . strtolower($controller) . 'Controller.php';
        $controllerName = $controller . 'Controller';
        return new $controllerName();
    }

    public function loadInclude($include) {
        if (file_exists('app/include/' . strtolower($include) . '.php')) {
            require_once 'app/include/' . strtolower($include) . '.php';
            return new $include();
        }
    }

    public function checkUserMembershipSite() {
        if ($this->session->get('activeUser')) {
            if(!$this->tools->checkUserMembershipActiongroup() ) {
                $this->tools->redirect(URL . 'home/index');
            }
        }
    }
    
    public function vardump($variable) {
        echo "<pre>";
        var_dump($variable);
        echo "</pre>";
    }
}
