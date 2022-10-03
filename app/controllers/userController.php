<?php

class userController extends controller {

    public $userModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = $this->loadModel("user");
    }

    public function updateAction($userId = false) {
        $this->tools->checkPageRights(4);
        $userModel = $this->loadModel('user');
        $actiongroupModel = $this->loadModel('actiongroup');
        $membershipModel = $this->loadModel('membership');
        $allActiongroups = [];
        $userMemberships = [];

        if ($userId) {
            $userModel->getOneBy('id', $userId);
            $allActiongroups = $actiongroupModel->getAll();
            $userMemberships = $membershipModel->getAllUsersMemberships($userId);
        }

        if ($this->tools->getPost('action') == 'handleuser') {
            $userModel->setName($this->tools->getPost('user-name'));
            $userModel->setSurname($this->tools->getPost('user-surname'));
            $userModel->setUsername($this->tools->getPost('user-email'));
            $userModel->setEmail($this->tools->getPost('user-email'));
            if (!$userModel->getId()) {
                $userModel->setPassword(password_hash($this->tools->getPost('user-password'), PASSWORD_DEFAULT));
            }
            $userModel->setLevel($this->tools->getPost('user-level'));
            $userModel->setActive(1);
            $userModel->flush();
            $this->tools->log('user', "User: " . $userModel->getEmail() . " successfully added.", __METHOD__);
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
            $this->tools->log('user', "User with id: $userId removed.", __METHOD__);
            $this->tools->redirect(URL . 'user/update');
        } else {
            echo "No user id selected!";
        }
    }
    
    public function chpassAction($userId) {
        $notification = "";
        if ($userId && ($this->session->get('activeUser')['id'] == $userId || $this->session->get('activeUser')['level'] == 5)) {
            $userModel = $this->loadModel('user');
            $selected_user = $userModel->getOneBy('id', $userId);
                if ($this->tools->getPost('action') == 'handlepass') {
                    if ($this->tools->getPost('old-pass') != ""
                    && $this->tools->getPost('new-pass') != ""
                    && $this->tools->getPost('confirm-new-pass') != "") {
                        if (password_verify($this->tools->getPost('old-pass'), $selected_user->password)) {
                            if ($this->tools->getPost('new-pass') == $this->tools->getPost('confirm-new-pass')) {
                                $selected_user->setPassword(password_hash($this->tools->getPost('new-pass'), PASSWORD_DEFAULT));
                                $selected_user->flush();
                                $this->tools->log('password', "User: " . $userModel->getEmail() . " successfully changed password.", __METHOD__);
                                $this->tools->redirect(URL . 'user/update/' . $userId);
                            } else {
                                $notification = "New password don't match with confirm password!<br>";
                            }
                        } else {
                            $notification = "Old password not correct!<br>";
                        }
                    } else {
                        $notification = "Empty fields!<br>";
                    }
                }
            $this->view->assign('notification', $notification);
            $this->view->assign('selected_user', $selected_user);
            $this->view->render('user/chpass');
        } else {
            $this->tools->redirect(URL . 'user/update/' . $userId);
        }
    }

    public function loginAction() {
        $time_over = (abs(time() - $this->session->get('lg_at')) > LOGIN_PENALTY_DURATION) ? true : false;
        
        if ($this->tools->getPost("login-action") 
        && $this->tools->getPost("login-action") == "login" 
        && $this->tools->getPost('login-email') != "" 
        && $this->tools->getPost('login-password') != "") {
            if (LIMIT_LOGIN_ATTEMPTS) {
                if ($time_over) {
                    $this->session->set('lg_f', 1);
                    $this->session->set('lg_at', time());
                    if ($this->userModel->login()) {
                        $this->session->set('lg_f', 0);
                        $this->tools->redirect(URL . 'home');
                    }
                } else {
                    if ($this->session->get('lg_f') !=  MAX_LOGIN_ATTEMPTS) {
                        $this->session->set('lg_f', $this->session->get('lg_f') + 1);
                        $this->session->set('lg_at', time());
                        if ($this->userModel->login()) {
                            $this->session->set('lg_f', null);
                            $this->tools->redirect(URL . 'home');
                        }
                    }
                }
            } else {
                if ($this->userModel->login()) {
                    $this->tools->redirect(URL . 'home');
                }
            }
        }
        $this->view->assign('time_over', $time_over);
        $this->view->render('user/login');
    }

    public function logoutAction() {
        unset($_SESSION[APP_NAME . "_" . 'user']);
        $_SESSION = array();
        session_destroy();
        $this->tools->redirect(URL);
    }
}
