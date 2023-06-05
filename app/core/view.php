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
    }

    public function render($view, $displayHeader = true) {
        if (DISPLAY_PAGE_HEADER && $displayHeader) $this->displayHead();
        $data = $this->vars;
        $contentPath = "content/";
        if (file_exists('app/views/' . $this->config->getParam('template') . '/' . $view . '.php')) {
            $contentPath = "";
        } else if (file_exists('app/views/default/' . $view . '.php')) {
            $contentPath = "";
        }

        if ($contentPath && !file_exists('app/content/views/' . $this->config->getParam('template') . '/' . $view . '.php')) {
            if ($contentPath && !file_exists('app/content/views/default/' . $view . '.php')) {
                die("Err: View file is missing.");
            }
        }
        if (!$contentPath && file_exists('app/content/views/' . $this->config->getParam('template') . '/' . $view . '.php')) {
            die("Err: View file exists in base and in content.");
        }
        if (file_exists('app/' . $contentPath . 'views/' . $this->config->getParam('template') . '/' . $view . '.php')) { 
            require 'app/' . $contentPath . 'views/' . $this->config->getParam('template') . '/' . $view . '.php';
        } else {
            require 'app/' . $contentPath . 'views/default/' . $view . '.php';
        }
    }

    public function assign($key, $value) {
        $this->vars[$key] = $value;
    }

    private function displayHead() {
        require_once 'app/models/menuModel.php';
        $menuModel = new menuModel;
        $allMenuItems = $menuModel->getMenuItems(false, true, 'all');
        $allAdminMenuItems = $menuModel->getMenuItems(true, true, 'all');
        $parentGroups = $menuModel->getMenuItems(false, true, '0');
        if (file_exists('app/views/' . $this->config->getParam('template') . '/basic/head.php')) {
            $header_view = 'app/views/' . $this->config->getParam('template') . '/basic/head.php';
        } else {
            $header_view = 'app/views/default/basic/head.php';
        }
        require_once $header_view;
    }
}
