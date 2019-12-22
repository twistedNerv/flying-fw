<?php
require 'app/config/globals.php';
require 'app/config/tools.php';

class config {
    public $configValues = [];
    
    public function __construct() {
        $this->configValues = 
            [
                'title' => 'mvc',
                'template' => 'default',
                'display_page_menu' => true
            ];
    }
    
    public function getParam($param) {
        return $this->configValues[$param];
    }
    
    public function setParam($param, $value) {
        $this->configValues[$param] = $value;
    }
    
    public function includeStyle($filename) {
        echo "<link rel='stylesheet' href='" . URL . "public/" . $this->getParam('template') . "/css/" . $filename . "'>";
    }
    
    public function includeScript($filename) {
        echo "<script type='text/javascript' src='" . URL . "public/" . $this->getParam('template') . "/js/" . $filename . "'></script>";
    }
    
    public function includeBootstrap() {
        echo "<link rel='stylesheet' href='" . URL . "public/" . $this->getParam('template') . "/custom/bootstrap-4.3.1/css/bootstrap.min.css'>";
        echo "<script type='text/javascript' src='" . URL . "public/" . $this->getParam('template') . "/custom/bootstrap-4.3.1/js/bootstrap.min.js'></script>";
    }
}