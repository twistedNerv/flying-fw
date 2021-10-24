<?php

class userController extends controller {

    public $userModel;
    
    public function __construct() {
        parent::__construct();
        $this->userModel = $this->loadModel("user");
    }

    public function updateAction($userId=false) {
        $this->tools->checkPageRights(4);
        $userModel = $this->loadModel('user');
        $actiongroupModel = $this->loadModel('actiongroup');
        $membershipModel = $this->loadModel('membership');
        $allActiongroups = [];
        $userMemberships = [];
        
        if($userId) {
            $userModel->getOneBy('id', $userId);
            $allActiongroups = $actiongroupModel->getAll();
            $userMemberships = $membershipModel->getAllUsersMemberships($userId);
        }
        
        if($this->tools->getPost('action') == 'handleuser') {
            $userModel->setName($this->tools->getPost('user-name'));
            $userModel->setSurname($this->tools->getPost('user-surname'));
            $userModel->setUsername($this->tools->getPost('user-email'));
            $userModel->setEmail($this->tools->getPost('user-email'));
            if(!$userModel->getId()) {
                $userModel->setPassword(md5($this->tools->getPost('user-password')));
            }
            $userModel->setLevel($this->tools->getPost('user-level'));
            $userModel->setActive(1);
            $userModel->flush();
            $this->tools->log('user', "User: " . $userModel->getEmail() . " successfully added.");
        }
        $allUsers = $userModel->getAll();
        $this->view->assign('allUsers', $allUsers);
        $this->view->assign('allActiongroups', $allActiongroups);
        $this->view->assign('userMemberships', $userMemberships);
        $this->view->assign('selectedUser', $userModel);
        $this->view->render('user/update');
    }
    
    
    public function removeAction($userId) {
        $this->tools->checkPageRights(4);
        if ($userId) {
            $userModel = $this->loadModel('user');
            $userModel->getOneBy('id', $userId);
            $userModel->remove();
            $this->tools->log('user', "User with id: $userId removed.");
            $this->tools->redirect(URL . 'user/update');
        } else {
            echo "No user id selected!";
        }
    }
    
    public function loginAction() {
        if ($this->tools->getPost("login-action")) {
            if ($this->tools->getPost("login-action") == "login" && $this->tools->getPost('login-email') != "" && $this->tools->getPost('login-password') != "") {
                $this->userModel->login();
            }
        }
        $this->view->render('user/login');
    }
    
    public function logoutAction() {
        unset($_SESSION[APP_NAME . "_" . 'user']);
        $_SESSION = array();
        session_destroy();
        $this->tools->redirect(URL);
    }
}
