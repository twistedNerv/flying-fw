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

    public function findOneById($value) {
        $result = $this->db->findOneByParam('id', $value, 'user');
        $this->fillUser($result);
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function findOneByName($value) {
        $result = $this->db->findOneByParam('name', $value, 'user');
        $this->fillUser($result);
        return $this;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function setSurname($surname) {
        $this->surname = $surname;
        return $this;
    }

    public function findOneBySurname($value) {
        $result = $this->db->findOneByParam('surname', $value, 'user');
        $this->fillUser($result);
        return $this;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    public function findOneByUsername($value) {
        $result = $this->db->findOneByParam('username', $value, 'user');
        $this->fillUser($result);
        return $this;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    public function findOneByPassword($value) {
        $result = $this->db->findOneByParam('password', $value, 'user');
        $this->fillUser($result);
        return $this;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function findOneByEmail($value) {
        $result = $this->db->findOneByParam('email', $value, 'user');
        $this->fillUser($result);
        return $this;
    }

    public function getLocation() {
        return $this->location;
    }

    public function setLocation($location) {
        $this->location = $location;
        return $this;
    }

    public function findOneByLocation($value) {
        $result = $this->db->findOneByParam('location', $value, 'user');
        $this->fillUser($result);
        return $this;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function findOneByDescription($value) {
        $result = $this->db->findOneByParam('description', $value, 'user');
        $this->fillUser($result);
        return $this;
    }

    public function getLevel() {
        return $this->level;
    }

    public function setLevel($level) {
        $this->level = $level;
        return $this;
    }

    public function findOneByLevel($value) {
        $result = $this->db->findOneByParam('level', $value, 'user');
        $this->fillUser($result);
        return $this;
    }

    public function getActive() {
        return $this->active;
    }

    public function setActive($active) {
        $this->active = $active;
        return $this;
    }

    public function findOneByActive($value) {
        $result = $this->db->findOneByParam('active', $value, 'user');
        $this->fillUser($result);
        return $this;
    }

    public function getLastloginDT() {
        return $this->lastloginDT;
    }

    public function setLastloginDT($lastloginDT) {
        $this->lastloginDT = $lastloginDT;
        return $this;
    }

    public function findOneByLastloginDT($value) {
        $result = $this->db->findOneByParam('lastloginDT', $value, 'user');
        $this->fillUser($result);
        return $this;
    }

    public function getLastloginIP() {
        return $this->lastloginIP;
    }

    public function setLastloginIP($lastloginIP) {
        $this->lastloginIP = $lastloginIP;
        return $this;
    }

    public function findOneByLastloginIP($value) {
        $result = $this->db->findOneByParam('lastloginIP', $value, 'user');
        $this->fillUser($result);
        return $this;
    }

    public function getCreatedDT() {
        return $this->createdDT;
    }

    public function setCreatedDT($createdDT) {
        $this->createdDT = $createdDT;
        return $this;
    }

    public function findOneByCreatedDT($value) {
        $result = $this->db->findOneByParam('createdDT', $value, 'user');
        $this->fillUser($result);
        return $this;
    }

    public function getCreatedIP() {
        return $this->createdIP;
    }

    public function setCreatedIP($createdIP) {
        $this->createdIP = $createdIP;
        return $this;
    }

    public function findOneByCreatedIP($value) {
        $result = $this->db->findOneByParam('createdIP', $value, 'user');
        $this->fillUser($result);
        return $this;
    }

    public function getTheme() {
        return $this->theme;
    }

    public function setTheme($theme) {
        $this->theme = $theme;
        return $this;
    }

    public function findOneByTheme($value) {
        $result = $this->db->findOneByParam('theme', $value, 'user');
        $this->fillUser($result);
        return $this;
    }

    public function findAll() {
        return $this->db->findAll('user');
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
        if ($this->db->result->rowCount() == 1) {
            $_SESSION[APP_NAME . "_" . 'activeUser'] = $this->db->result->fetch(PDO::FETCH_ASSOC);
            $tools = new tools; //$this->loadModel('tools');
            $session = new session();
            $tools->log("login", "Logged in: userid: " . $session->get('activeUser')['id'] . " / mail: " . $_POST['login-email']);
            //header('location: index');
            
            tools::redirect(URL . 'index');
        } else {
            tools::log("login", "Failed for userid: " . $_POST['login-email'] . " / pass: " . $_POST['login-password'] . ").");
        }
    }
}
