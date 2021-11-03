<?php

class devmoduleModel extends model {

	public $id;
	public $testtext;
	public $testpassword;
	public $testnumber;
	public $testdescription;
	public $testeditor;
	public $testemail;
	public $testdate;
	public $testcolor;
	public $testselect;
	public $testradio;
	public $testcheckbox;


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

	public function getTesttext() {
		return $this->testtext;
	}

	public function setTesttext($testtext) {
		$this->testtext = $testtext;
		return $this;
	}

	public function getTestpassword() {
		return $this->testpassword;
	}

	public function setTestpassword($testpassword) {
		$this->testpassword = $testpassword;
		return $this;
	}

	public function getTestnumber() {
		return $this->testnumber;
	}

	public function setTestnumber($testnumber) {
		$this->testnumber = $testnumber;
		return $this;
	}

	public function getTestdescription() {
		return $this->testdescription;
	}

	public function setTestdescription($testdescription) {
		$this->testdescription = $testdescription;
		return $this;
	}

	public function getTesteditor() {
		return $this->testeditor;
	}

	public function setTesteditor($testeditor) {
		$this->testeditor = $testeditor;
		return $this;
	}

	public function getTestemail() {
		return $this->testemail;
	}

	public function setTestemail($testemail) {
		$this->testemail = $testemail;
		return $this;
	}

	public function getTestdate() {
		return $this->testdate;
	}

	public function setTestdate($testdate) {
		$this->testdate = $testdate;
		return $this;
	}

	public function getTestcolor() {
		return $this->testcolor;
	}

	public function setTestcolor($testcolor) {
		$this->testcolor = $testcolor;
		return $this;
	}

	public function getTestselect() {
		return $this->testselect;
	}

	public function setTestselect($testselect) {
		$this->testselect = $testselect;
		return $this;
	}

	public function getTestradio() {
		return $this->testradio;
	}

	public function setTestradio($testradio) {
		$this->testradio = $testradio;
		return $this;
	}

	public function getTestcheckbox() {
		return $this->testcheckbox;
	}

	public function setTestcheckbox($testcheckbox) {
		$this->testcheckbox = $testcheckbox;
		return $this;
	}

	public function getOneBy($ident, $value) {
		$result = $this->db->getOneByParam($ident, $value, 'devmodule');
		$this->fillDevmodule($result);
		return $this;
	}

	public function getAll($orderBy = null, $order = null, $limit = null) {
		return $this->db->getAll($orderBy, $order, $limit, 'devmodule');
	}

public function getAllBy($ident, $identVal, $orderBy = null, $orderDirection = 'ASC', $limit=null) {
return $this->db->getAllByParam($ident, $identVal, 'devmodule', $orderBy, $orderDirection, $limit);
	}

	public function flush($sqlDump=0) {
		$this->db->flush($this, 'devmodule', $sqlDump);
	}

	public function remove() {
		$this->db->delete($this, 'devmodule');
	}

	public function fillDevmodule($data) {
		$columns = $this->db->getTableColumns('devmodule');
		foreach($data as $key => $value) {
			$this->$key = $value;
		}
		return $this;
	}
}