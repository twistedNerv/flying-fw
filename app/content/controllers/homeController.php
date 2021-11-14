<?php

class homeController extends controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function indexAction() {
        $this->view->render("home/index");
    }
}