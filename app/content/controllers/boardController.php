<?php

class boardController extends controller {

    public function __construct() {
        parent::__construct();
    }
    
    public function indexAction() {
        $boardModel = $this->loadModel('board');
        $allItems   = $boardModel->findAllSortedBy('id', 'desc', 4);
        $this->view->assign('items', $allItems);
        $this->view->render("board/index");
    }

    public function updateAction($id = 0) {
        $boardModel = $this->loadModel("board");
        if ($id != 0) {
            $boardModel->findOneById($id);
        }
        if (isset($_POST["action"]) && $_POST["action"] == "handleboard") {
            $boardModel->setTitle($this->tools->sanitizePost($_POST["board-title"]));
            $boardModel->setContent($this->tools->sanitizePost($_POST["board-content"]));
            $boardModel->setPostdate(date('d.m.Y H:i:s'));
            $boardModel->setPostuser($this->session->get('activeUser')['name'] . " " . $this->session->get('activeUser')['surname']);
            $boardModel->flush();
            $action = ($id != 0) ? "Board element with id: $id updated successfully." : "Board successfully added.";
            $this->tools->notification("Board element dodan/urejen.", "primary");
            $this->tools->log("board", $action);
        }
        $allItems = $boardModel->findAllSortedBy('id', 'desc', 20);
        $this->view->assign('items', $allItems);
        $this->view->assign('selectedBoard', $boardModel);
        $this->view->render("board/update");
    }

    public function removeAction($id) {
        if ($id) {
            $boardModel = $this->loadModel("board");
            $boardModel->findOneById($id);
            $boardModel->remove();
            $this->tools->log("board", "Board element with id: $id removed.");
            $this->tools->redirect(URL . "board/update");
        } else {
            echo "No board element id selected!";
        }
    }

}
