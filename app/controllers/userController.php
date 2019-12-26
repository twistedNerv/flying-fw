<?php

class userController extends controller {

    public $userModel;
    public function __construct() {
        parent::__construct();
        $this->userModel = $this->loadModel("user");
    }

    public function indexAction() {
        $this->tools->checkPageRights(4);
        $this->userModel->findOneById(10);
        $this->view->assign('name', $this->userModel->name);
        $this->view->render('user/index');
        $this->view->render('home/index');
    }
    
    public function updateAction($userId=false) {
        $userModel = $this->loadModel('user');
        if($userId) {
            $userModel->findOneById($userId);
        }
        if(isset($_POST['action']) && $_POST['action'] == 'handleuser') {
            $userModel->setName(tools::sanitizePost($_POST['user-name']));
            $userModel->setSurname(tools::sanitizePost($_POST['user-surname']));
            $userModel->setUsername(tools::sanitizePost($_POST['user-email']));
            $userModel->setEmail(tools::sanitizePost($_POST['user-email']));
            if(!$userModel->getId()) {
                $userModel->setPassword(md5(tools::sanitizePost($_POST['user-password'])));
            }
            $userModel->setLevel(tools::sanitizePost($_POST['user-level']));
            $userModel->setActive(1);
            $userModel->flush();
            $this->tools->notification("Uporabnik urejen.", "primary");
            $this->tools->log('user', "User: " . $userModel->getEmail() . " successfully added.");
        }
        $allUsers = $userModel->findAll();
        $this->view->assign('allUsers', $allUsers);
        $this->view->assign('selectedUser', $userModel);
        $this->view->render('user/update');
    }
    
    public function removeAction($userId) {
        if ($userId) {
            $userModel = $this->loadModel('user');
            $userModel->findOneById($userId);
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
        unset($_SESSION['user']);
        $_SESSION = array();

//        if(ini_get("session.use_cookies")) {
//            $params = session_get_cookie_params();
//            setcookie(session_name(), '', time() - 42000,
//                $params["path"], $params["domain"],
//                $params["secure"], $params["httponly"]
//            );
//        }
        session_destroy();
        tools::redirect(URL . 'user/login');
        //header('location: '.URL.'user/login.php');
    }
}
