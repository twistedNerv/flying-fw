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
        
        if(isset($_POST['action']) && $_POST['action'] == 'handleuser') {
            $userModel->setName($this->tools->sanitizePost($_POST['user-name']));
            $userModel->setSurname($this->tools->sanitizePost($_POST['user-surname']));
            $userModel->setUsername($this->tools->sanitizePost($_POST['user-email']));
            $userModel->setEmail($this->tools->sanitizePost($_POST['user-email']));
            if(!$userModel->getId()) {
                $userModel->setPassword(md5($this->tools->sanitizePost($_POST['user-password'])));
            }
            $userModel->setLevel($this->tools->sanitizePost($_POST['user-level']));
            $userModel->setActive(1);
            $userModel->flush();
            $this->tools->notification("Uporabnik urejen.", "primary");
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
        if (isset($_POST["login-action"])) {
            if ($_POST["login-action"] == "login" && $_POST['login-email'] != "" && $_POST['login-password'] != "") {
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
