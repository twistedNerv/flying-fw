<?php
require 'app/config/globals.php';

class config {
    public $configValues = [];
    
    public function __construct() {
        $this->configValues = 
            [
                'title' => TITLE,
                'header_title' => HEADER_TITLE,
                'template' => TEMPLATE,
                'display_page_header' => DISPLAY_PAGE_HEADER
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
    
    public function includeJquery() {
        echo "<link rel='stylesheet' href='" . URL . "public/default/custom/jquery-3.4.1/jquery-ui.css'>";
        echo "<script type='text/javascript' src='" . URL . "public/default/custom/jquery-3.4.1/jquery.js'></script>";
        echo "<script type='text/javascript' src='" . URL . "public/default/custom/jquery-3.4.1/jquery-ui.js'></script>";
    }
    
    public function includeBootstrap() {
        echo "<link rel='stylesheet' href='" . URL . "public/default/custom/bootstrap-4.3.1/css/bootstrap.min.css'>";
        echo "<script type='text/javascript' src='" . URL . "public/default/custom/bootstrap-4.3.1/js/bootstrap.min.js'></script>";
    }
    
    public function includeFontawesome() {
        echo "<link rel='stylesheet' href='" . URL . "public/default/custom/fontawesome-free-5.12.0-web/css/all.css'>";
    }
    
    public function includeFontawesomeCustom() {
        echo "<link rel='stylesheet' href='" . URL . "public/" . $this->getParam('template') . "/custom/fontawesome-free-5.12.0-web/css/all.css'>";
    }
    
    public function includeTimeline() {
        echo "<script type='text/javascript' src='" . URL . "public/default/custom/timeline/timeline.min.js'></script>";
        echo "<script type='text/javascript' src='" . URL . "public/default/custom/timeline/tether.min.js'></script>";
        echo "<link rel='stylesheet' href='" . URL . "public/default/custom/timeline/jquery.timeline.min.css'>";
    }
    
    public function includeEasyeditor() {
        echo "<script type='text/javascript' src='" . URL . "public/default/custom/easyeditor/jquery.easyeditor.js'></script>";
        echo "<link rel='stylesheet' href='" . URL . "public/default/custom/easyeditor/easyeditor.css'>";
        echo "<link rel='stylesheet' href='" . URL . "public/default/custom/easyeditor/easyeditor-modal.css'>";
    }
    
    public function includeLibsFont($fontname) {
        echo "<link rel='stylesheet' href='" . URL . "public/default/custom/fonts/fonts-" . $fontname .".css'>";
    }
}