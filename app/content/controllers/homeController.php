<?php

class homeController extends controller {
    
    public function __construct() {
        parent::__construct();
        $this->tools->checkPageRights(4);
    }
    
    public function indexAction($name='') {
        $homeModel = $this->loadModel('home');
        $name = $homeModel->test("bla");
        $this->view->assign('name', $name);
        $this->view->render('home/index');
    }
}