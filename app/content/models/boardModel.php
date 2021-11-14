<?php

class boardModel extends model {

    public $id;
    public $title;
    public $content;
    public $postdate;
    public $postuser;
    public $visible;

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

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function getPostdate() {
        return $this->postdate;
    }

    public function setPostdate($postdate) {
        $this->postdate = $postdate;
        return $this;
    }

    public function getPostuser() {
        return $this->postuser;
    }

    public function setPostuser($postuser) {
        $this->postuser = $postuser;
        return $this;
    }

    public function getVisible() {
        return $this->visible;
    }

    public function setVisible($visible) {
        $this->visible = $visible;
        return $this;
    }

    public function getOneBy($ident, $value) {
        $result = $this->db->getOneByParam($ident, $value, 'board');
        $this->fillBoard($result);
        return $this;
    }

    public function getAll($orderBy = null, $order = null, $limit = null) {
        return $this->db->getAll($orderBy, $order, $limit, 'board');
    }

    public function getAllBy($ident, $identVal, $orderBy = null, $orderDirection = 'ASC', $limit = null) {
        return $this->db->getAllByParam($ident, $identVal, 'board', $orderBy, $orderDirection, $limit);
    }

    public function flush($sqlDump = 0) {
        $this->db->flush($this, 'board', $sqlDump);
    }

    public function remove() {
        $this->db->delete($this, 'board');
    }

    public function fillBoard($data) {
        $columns = $this->db->getTableColumns('board');
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
        return $this;
    }
}
