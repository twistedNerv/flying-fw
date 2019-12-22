<?php

class controller {

    public function __construct() {
        $this->model = new model();
        $this->view = new view();
        $this->session = new session();
        $this->config = new config;
        $this->tools = new tools;
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

}
