<?php

class testModel extends model {

	public $id;
	public $aaa;
	public $bbb;


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
		$result = $this->db->findOneByParam('id', $value, 'test');
		$this->fillTest($result);
		return $this;
	}

	public function getAaa() {
		return $this->aaa;
	}

	public function setAaa($aaa) {
		$this->aaa = $aaa;
		return $this;
	}

	public function findOneByAaa($value) {
		$result = $this->db->findOneByParam('aaa', $value, 'test');
		$this->fillTest($result);
		return $this;
	}

	public function getBbb() {
		return $this->bbb;
	}

	public function setBbb($bbb) {
		$this->bbb = $bbb;
		return $this;
	}

	public function findOneByBbb($value) {
		$result = $this->db->findOneByParam('bbb', $value, 'test');
		$this->fillTest($result);
		return $this;
	}

	public function findAll() {
		return $this->db->findAll('test');
	}

	public function flush($sqlDump=0) {
		$this->db->flush($this, 'test', $sqlDump);
	}

	public function remove() {
		$this->db->delete($this, 'test');
	}

	public function fillTest($data) {
		$columns = $this->db->getTableColumns('test');
		foreach($data as $key => $value) {
			$this->$key = $value;
		}
		return $this;
	}
}