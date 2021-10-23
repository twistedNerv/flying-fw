<?php

class userModel extends model {

    public $id;
    public $name;
    public $surname;
    public $username;
    public $password;
    public $email;
    public $location;
    public $description;
    public $level;
    public $active;
    public $lastloginDT;
    public $lastloginIP;
    public $createdDT;
    public $createdIP;
    public $theme;

    public function __construct() {
        parent::__construct();
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function setSurname($surname) {
        $this->surname = $surname;
        return $this;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function getLocation() {
        return $this->location;
    }

    public function setLocation($location) {
        $this->location = $location;
        return $this;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function getLevel() {
        return $this->level;
    }

    public function setLevel($level) {
        $this->level = $level;
        return $this;
    }

    public function getActive() {
        return $this->active;
    }

    public function setActive($active) {
        $this->active = $active;
        return $this;
    }

    public function getLastloginDT() {
        return $this->lastloginDT;
    }

    public function setLastloginDT($lastloginDT) {
        $this->lastloginDT = $lastloginDT;
        return $this;
    }

    public function getLastloginIP() {
        return $this->lastloginIP;
    }

    public function setLastloginIP($lastloginIP) {
        $this->lastloginIP = $lastloginIP;
        return $this;
    }

    public function getCreatedDT() {
        return $this->createdDT;
    }

    public function setCreatedDT($createdDT) {
        $this->createdDT = $createdDT;
        return $this;
    }

    public function getCreatedIP() {
        return $this->createdIP;
    }

    public function setCreatedIP($createdIP) {
        $this->createdIP = $createdIP;
        return $this;
    }

    public function getTheme() {
        return $this->theme;
    }

    public function setTheme($theme) {
        $this->theme = $theme;
        return $this;
    }

    public function getOneBy($ident, $value) {
        $result = $this->db->getOneByParam($ident, $value, 'user');
        $this->fillUser($result);
        return $this;
    }

    public function getAll($orderBy = null, $order = null, $limit = null) {
        return $this->db->getAll($orderBy, $order, $limit, 'user');
    }
    
    public function getAllBy($ident, $identVal, $orderBy = null, $orderDirection = 'ASC', $limit=null) {
        return $this->db->getAllByParam($ident, $identVal, 'user', $orderBy, $orderDirection, $limit);
    }

    public function flush($sqlDump=0) {
        $this->db->flush($this, 'user', $sqlDump);
    }

    public function remove() {
        $this->db->delete($this, 'user');
    }

    public function fillUser($data) {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
        return $this;
    }

    public function login() {
        $cryptPass = md5($_POST['login-password']);
        $this->db->result = $this->db->prepare("SELECT * FROM user WHERE email = :email AND password = :password;");
        $this->db->result->bindParam(':email', $_POST['login-email']);
        $this->db->result->bindParam(':password', $cryptPass);
        $this->db->result->execute();
        $tools = new tools; //$this->loadModel('tools');
        if ($this->db->result->rowCount() == 1) {
            $_SESSION[APP_NAME . "_" . 'activeUser'] = $this->db->result->fetch(PDO::FETCH_ASSOC);
            $session = new session();
            $tools->log("login", "Logged in: userid: " . $session->get('activeUser')['id'] . " / mail: " . $_POST['login-email']);
            //header('location: index');
            
            $tools->redirect(URL . 'index');
        } else {
            $tools->log("login", "Failed for userid: " . $_POST['login-email'] . " / pass: " . $_POST['login-password'] . ").");
        }
    }
}
