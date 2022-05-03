<?php

class boardController extends controller {

    public function __construct() {
        //load all from parent controller class
        parent::__construct();
        //prevent unauthorized access and set access level 
        $this->tools->checkPageRights(1);
    }
    
    public function indexAction() {
        //create object from model board
        $boardModel = $this->loadModel('board');
        //save last 4 records from the table in $allItems variable
        $allItems   = $boardModel->getAll('id', 'desc', 4);
        //prepare vars for view ($allItems will be accessable via $data['items']
        $this->view->assign('items', $allItems);
        //render page with code from file located in content/view/[template]/board/index.php
        $this->view->render("board/index");
    }

    public function updateAction($id = 0) {
        //set higher access level for user access
        $this->tools->checkPageRights(3);
        //create object from model 'board'
        $boardModel = $this->loadModel("board");
        //if $id exists, fill the object with data from DB, otherwise leave object empty
        if ($id) {
            $boardModel->getOneBy('id', $id);
        }
        //if form was triggered
        if ($this->tools->getPost("action") == "handleboard") {
            //set values through setters
            $boardModel->setTitle($this->tools->getPost("board-title"));
            $boardModel->setContent($this->tools->getPost("board-content"));
            $boardModel->setPostdate(date('d.m.Y H:i:s'));
            $boardModel->setPostuser($this->session->get('activeUser')['name'] . " " . $this->session->get('activeUser')['surname']);
            //save changes (if var id in object exists, update record, otherwise create new
            $boardModel->flush();
            //prepare log description
            $action = ($id != 0) ? "Board element with id: $id updated successfully." : "Board successfully added.";
            //save action in logs
            $this->tools->log("board", $action);
        }
        //get top 20 records ordered by id desc
        $allItems = $boardModel->getAll('id', 'desc', 20);
        //prepare vars for view
        $this->view->assign('items', $allItems);
        $this->view->assign('selectedBoard', $boardModel);
        //render page
        $this->view->render("board/update");
    }

    public function removeAction($id) {
        //set higher access level for user access
        $this->tools->checkPageRights(3);
        //check if $id exists, otherwise do not delete
        if ($id) {
            //load model
            $boardModel = $this->loadModel("board");
            //fill object
            $boardModel->getOneBy('id', $id);
            //delete record in DB table
            $boardModel->remove();
            //save action in logs
            $this->tools->log("board", "Board element with id: $id removed.");
            //redirect to board update page
            $this->tools->redirect(URL . "board/update");
        } else {
            echo "No board element id selected!";
        }
    }

}
