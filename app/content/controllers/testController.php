<?php

class testController extends controller {

	public function __construct() { 
		parent::__construct();
	}

	public function indexAction($id=0) {
		$this->view->render("test/index");
	}

	public function updateAction($id=0) {
		$this->tools->checkPageRights(4);
		$testModel = $this->loadModel("test");
		if($id != 0) {
			$testModel->findOneById($id);
		}
		if(isset($_POST["action"]) && $_POST["action"] == "handletest") {
			$testModel->setAaa($this->tools->sanitizePost($_POST["test-aaa"]));
			$testModel->setBbb($this->tools->sanitizePost($_POST["test-bbb"]));
			$testModel->flush();
			$action = ($id != 0) ? "Test element with id: $id updated successfully." : "test successfully added.";
			$this->tools->notification("test element dodan/urejen.", "primary");
			$this->tools->log("test", $action);
		}
		$columns = $testModel->db->getTableColumns('test');
		$allItems = $testModel->findAll();
		$this->view->assign("items", $allItems);
		$this->view->assign("selectedTest", $testModel);
		$this->view->assign("columns", $columns);
		$this->view->render("test/update");
	}

	public function removeAction($id) {
		if ($id) {
			$testModel = $this->loadModel("test");
			$testModel->findOneById($id);
			$testModel->remove();
			$this->tools->log("test", "Test element with id: $id removed.");
			$this->tools->redirect(URL . "test/update");
		} else {
			echo "No test element id selected!";
		}
	}
}