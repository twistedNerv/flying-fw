<?php

class homeController extends controller {
    
    public function __construct() {
        parent::__construct();
        $this->tools->checkPageRights(4);
    }
    
    public function indexAction() {
        $boardModel = $this->loadModel('board');
        $allItems = $boardModel->findAllSortedBy('id', 'desc', 5);
        $this->view->assign('items', $allItems);
        $this->view->render("home/index");
    }
}