<?php

class actiongroupModel extends model {

    public $id;
    public $name;
    public $description;
    public $action;
    public $section;

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

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function getAction() {
        return $this->action;
    }

    public function setAction($action) {
        $this->action = $action;
        return $this;
    }

    
    public function getSection() {
        return $this->section;
    }

    public function setSection($section) {
        $this->section = $section;
        return $this;
    }
    
    public function getOneBy($ident, $value) {
        $result = $this->db->getOneByParam($ident, $value, 'actiongroup');
        $this->fillActiongroup($result);
        return $this;
    }

    public function getAll($orderBy = null, $order = null, $limit = null) {
        return $this->db->getAll($orderBy, $order, $limit, 'actiongroup');
    }
    
    public function getAllBy($ident, $identVal, $orderBy = null, $orderDirection = 'ASC', $limit=null) {
        return $this->db->getAllByParam($ident, $identVal, 'actiongroup', $orderBy, $orderDirection, $limit);
    }

    public function flush($sqlDump = 0) {
        $this->db->flush($this, 'actiongroup', $sqlDump);
    }

    public function remove() {
        $this->db->delete($this, 'actiongroup');
    }

    public function fillActiongroup($data) {
        if (is_array($data) || is_object($data)) {
            foreach ($data as $key => $value) {
                $this->$key = $value;
            }
            return $this;
        }
    }
}
