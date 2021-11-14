<?php

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

    public function loadInclude($include) {
        if (file_exists('app/include/' . strtolower($include) . '.php')) {
            require_once 'app/include/' . strtolower($include) . '.php';
            return new $include();
        }
    }

    public function checkUserMembershipSite() {
        if(!$this->tools->checkUserMembershipActiongroup()) {
            $this->tools->redirect(URL . 'home/index');
        }
    }
}
