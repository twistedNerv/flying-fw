<?php
require_once 'app/include/template.php';
require_once 'app/include/tools.php';

class view {

    public $vars = [];
    
    public function __construct() {
        $this->session = new session;
        $this->config = new config;
        $this->template = new template;
        $this->tools = new tools;
        $this->displayHead();
    }
    
    public function render($view) {
        $data = $this->vars;
        $contentPath = "content/";
        if (file_exists('app/views/' . $this->config->getParam('template'). '/' . $view . '.php')) {
            $contentPath = "";
        }
        if ($contentPath && !file_exists('app/content/views/' . $this->config->getParam('template'). '/' . $view . '.php')) {
            die("Err: View file is missing.");
        }
        if (!$contentPath && file_exists('app/content/views/' . $this->config->getParam('template'). '/' . $view . '.php')) {
            die("Err: View file exists in base and in content.");
        }
        require 'app/' . $contentPath . 'views/' . $this->config->getParam('template'). '/' . $view . '.php';
    }
    
    public function assign($key, $value) {
        $this->vars[$key] = $value;
    }
    
    private function displayHead() {
        if($this->config->getParam('display_page_menu')) {
            require_once 'app/models/menuModel.php';
            $menuModel = new menuModel;
            $allMenuItems = $menuModel->findMenuItems(false, true, 'all');
            $allAdminMenuItems = $menuModel->findMenuItems(true, true, 'all');
            $customMenuArray = [];
            foreach($allMenuItems as $singleItem) {
                $index = ($singleItem['parent'] != 0) ? $singleItem['parenttitle'] : 0;
                $customMenuArray[$index][] =  ['title' => $singleItem['title'], 'url' => $singleItem['url'], 'parenttitle' => $singleItem['parenttitle']];
            }//echo "<pre>";var_dump($customMenuArray);
        }
        require_once 'app/views/' . $this->config->getParam('template'). '/basic/head.php';
    }
}