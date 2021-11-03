<?php

class devmoduleController extends controller {

	public function __construct() { 
		parent::__construct();
	}

	public function indexAction($id=0) {
		$devmoduleModel = $this->loadModel('devmodule');
		$devmoduleObj = $devmoduleModel->getAll();
		$this->view->assign('vars', get_class_vars('devmoduleModel'));
		$this->view->assign('items', $devmoduleObj);
		$this->view->render("devmodule/index");
	}

	public function updateAction($id=0) {
		$this->tools->checkPageRights(4);
		$devmoduleModel = $this->loadModel("devmodule");
		if($id != 0) {
			$devmoduleModel->getOneBy("id", $id);
		}
		if($this->tools->getPost("action") == "handledevmodule") {
			$devmoduleModel->setTesttext($this->tools->getPost("devmodule-testtext"));
			$devmoduleModel->setTestpassword($this->tools->getPost("devmodule-testpassword"));
			$devmoduleModel->setTestnumber($this->tools->getPost("devmodule-testnumber"));
			$devmoduleModel->setTestdescription($this->tools->getPost("devmodule-testdescription"));
			$devmoduleModel->setTesteditor($this->tools->getPost("devmodule-testeditor"));
			$devmoduleModel->setTestemail($this->tools->getPost("devmodule-testemail"));
			$devmoduleModel->setTestdate($this->tools->getPost("devmodule-testdate"));
			$devmoduleModel->setTestcolor($this->tools->getPost("devmodule-testcolor"));
			$devmoduleModel->setTestselect($this->tools->getPost("devmodule-testselect"));
			$devmoduleModel->setTestradio($this->tools->getPost("devmodule-testradio"));
			$devmoduleModel->setTestcheckbox($this->tools->getPost("devmodule-testcheckbox"));
			$devmoduleModel->flush();
			$action = ($id != 0) ? "Devmodule element with id: $id updated successfully." : "devmodule successfully added.";
			$this->tools->log("devmodule", $action);
			if ($id == 0)
				$this->tools->redirect(URL . "devmodule/update");
		}
		$allItems = $devmoduleModel->getAll();
		$this->view->assign("items", $allItems);
		$this->view->assign("selectedDevmodule", $devmoduleModel);
		$this->view->render("devmodule/update");
	}

	public function removeAction($id) {
		if ($id) {
			$devmoduleModel = $this->loadModel("devmodule");
			$devmoduleModel->getOneBy("id", $id);
			$devmoduleModel->remove();
			$this->tools->log("devmodule", "Devmodule element with id: $id removed.");
			$this->tools->redirect(URL . "devmodule/update");
		} else {
			echo "No devmodule element id selected!";
		}
	}
}