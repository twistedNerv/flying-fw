<?php

class homeController extends controller {
    
    public function __construct() {
        parent::__construct();
        $this->tools->checkPageRights(4);
    }
    
    public function indexAction() {
        $this->view->render("home/index");
    }
}