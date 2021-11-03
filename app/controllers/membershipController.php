<?php

class membershipController extends controller {

    public function __construct() {
        parent::__construct();
    }

    public function indexAction($id = 0) {
        $this->view->render("actiongroup/index");
    }

    public function updateAction($userId = 0) {
        $this->tools->checkPageRights(4);
        $membershipModel = $this->loadModel('membership');
        if ($userId && $this->tools->getPost('action') == 'handleactiongroup') {
            $membnershipExist = $membershipModel->getOneByUserAndGroup($userId, $this->tools->getPost('membership-group_id'));
            if (!$membnershipExist['id']) {
                $membershipModel->setUser_id($userId);
                $membershipModel->setActiongroup_id($this->tools->getPost('membership-group_id'));
                $membershipModel->flush();
                $this->tools->log('membership', "User with id " . $userId . " and group with id" . $this->tools->getPost('membership-group_id') . " added.");
            } else {
                echo "Not added. Already in.";
            }
        }
        $this->tools->redirect(URL . 'user/update/' . $userId);
    }

    public function removeAction($id, $userId) {
        $this->tools->checkPageRights(4);
        if ($userId) {
            $userModel = $this->loadModel('membership');
            $userModel->getOneBy('id', $id);
            $userModel->remove();
            $this->tools->log('membership', "Membership with id: $id removed.");
            $this->tools->redirect(URL . 'user/update/' . $userId);
        } else {
            echo "No user id selected!";
        }
    }

}
