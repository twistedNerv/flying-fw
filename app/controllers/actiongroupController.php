<?php

class actiongroupController extends controller {

    public function __construct() {
        parent::__construct();
    }

    public function indexAction($id = 0) {
        $this->view->render("actiongroup/index");
    }

    public function updateAction($id = 0) {
        $this->tools->checkPageRights(4);
        $actiongroupModel = $this->loadModel("actiongroup");
        $actiongroupUsers = [];
        
        if ($id != 0) {
            $actiongroupModel->getOneBy('id', $id);
            $membershipModel = $this->loadModel('membership');
            $actiongroupUsers = $membershipModel->getAllActiongroupUsers($id);
        }
        
        if ($this->tools->getPost("action") == "handleactiongroup") {
            $actiongroupModel->setName($this->tools->getPost("actiongroup-name"));
            $actiongroupModel->setDescription($this->tools->getPost("actiongroup-description"));
            $actiongroupModel->setAction($this->tools->getPost("actiongroup-action"));
            $actiongroupModel->setSection($this->tools->getPost("actiongroup-section"));
            $actiongroupModel->flush();
            $action = ($id != 0) ? "Actiongroup element with id: $id updated successfully." : "actiongroup successfully added.";
            $this->tools->log("actiongroup", $action);
        }
        $allItems = $actiongroupModel->getAll();
        $this->view->assign("items", $allItems);
        $this->view->assign("selectedActiongroup", $actiongroupModel);
        $this->view->assign("actiongroupUsers", $actiongroupUsers);
        $this->view->render("actiongroup/update");
    }

    public function removeAction($id) {
        if ($id) {
            $actiongroupModel = $this->loadModel("actiongroup");
            $actiongroupModel->getOneBy('id', $id);
            $actiongroupModel->remove();
            $this->tools->log("actiongroup", "Actiongroup element with id: $id removed.");
            $this->tools->redirect(URL . "actiongroup/update");
        } else {
            echo "No actiongroup element id selected!";
        }
    }

}
