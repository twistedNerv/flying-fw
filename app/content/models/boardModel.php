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

	public function findOneById($value) {
		$result = $this->db->findOneByParam('id', $value, 'board');
		$this->fillBoard($result);
		return $this;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setTitle($title) {
		$this->title = $title;
		return $this;
	}

	public function findOneByTitle($value) {
		$result = $this->db->findOneByParam('title', $value, 'board');
		$this->fillBoard($result);
		return $this;
	}

	public function getContent() {
		return $this->content;
	}

	public function setContent($content) {
		$this->content = $content;
		return $this;
	}

	public function findOneByContent($value) {
		$result = $this->db->findOneByParam('content', $value, 'board');
		$this->fillBoard($result);
		return $this;
	}

	public function getPostdate() {
		return $this->postdate;
	}

	public function setPostdate($postdate) {
		$this->postdate = $postdate;
		return $this;
	}

	public function findOneByPostdate($value) {
		$result = $this->db->findOneByParam('postdate', $value, 'board');
		$this->fillBoard($result);
		return $this;
	}

	public function getPostuser() {
		return $this->postuser;
	}

	public function setPostuser($postuser) {
		$this->postuser = $postuser;
		return $this;
	}

	public function findOneByPostuser($value) {
		$result = $this->db->findOneByParam('postuser', $value, 'board');
		$this->fillBoard($result);
		return $this;
	}

	public function getVisible() {
		return $this->visible;
	}

	public function setVisible($visible) {
		$this->visible = $visible;
		return $this;
	}

	public function findOneByVisible($value) {
		$result = $this->db->findOneByParam('visible', $value, 'board');
		$this->fillBoard($result);
		return $this;
	}

	public function findAll() {
		return $this->db->findAll('board');
	}

	public function flush($sqlDump=0) {
        $this->db->flush($this, 'board', $sqlDump);
    }

	public function remove() {
		$this->db->delete($this, 'board');
	}

	public function fillBoard($data) {
		$columns = $this->db->getTableColumns('board');
		foreach($data as $key => $value) {
			$this->$key = $value;
		}
		return $this;
	}
        
        public function findAllSortedBy($orderBy, $order, $limit=10) {
            return $this->db->findAllSortedLimited('board', $orderBy, $order, $limit);
        }
}