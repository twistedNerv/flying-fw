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
        if ($userId && isset($_POST['action']) && $_POST['action'] == 'handleactiongroup') {
            $membnershipExist = $membershipModel->findOneByUserAndGroup($userId, $_POST['membership-group_id']);
            if (!$membnershipExist['id']) {
                $membershipModel->setUser_id($userId);
                $membershipModel->setActiongroup_id($_POST['membership-group_id']);
                $membershipModel->flush();
                $this->tools->log('membership', "User with id " . $userId . " and group with id" . $_POST['membership-group_id'] . " added.");
            } else {
                $this->tools->notification("Ni dodano. Že predhodno vpisano.", "primary");
            }
        }
        $this->tools->redirect(URL . 'user/update/' . $userId);
    }

    public function removeAction($id, $userId) {
        $this->tools->checkPageRights(4);
        if ($userId) {
            $userModel = $this->loadModel('membership');
            $userModel->findOneBy('id', $id);
            $userModel->remove();
            $this->tools->log('membership', "Membership with id: $id removed.");
            $this->tools->redirect(URL . 'user/update/' . $userId);
        } else {
            echo "No user id selected!";
        }
    }

}
