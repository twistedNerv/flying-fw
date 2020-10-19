# flying-fw
Custom light PHP framework

Why yet another framework? Because I had time and it was fun :)

------------------------------------------
Installation:
1. copy code to prefered folder on server
2. update file: app/config/custom.php
3. run all scripts in app/dbschemas
4. default admin login: test@test.com / test

Module builder:
1. open builder/index
2. set source destination (db table / schema file / create new - write a name)
3. choose options to be created
4. confirm
If all options selected there should be created table in db/sql schema file, controller, model, index view, update view

Workflow:
Custom module (controller, module, views) is added to installation by default.

Controller code example:

  public function updateAction($id = 0) {
        $boardModel = $this->loadModel("board");
        if ($id != 0) {
            $boardModel->findOneById($id);
        }
        if (isset($_POST["action"]) && $_POST["action"] == "handleboard") {
            $boardModel->setTitle($this->tools->sanitizePost($_POST["board-title"]));
            $boardModel->setContent($this->tools->sanitizePost($_POST["board-content"]));
            $boardModel->setPostdate(date('d.m.Y H:i:s'));
            $boardModel->setPostuser($this->session->get('activeUser')['name'] . " " . $this->session->get('activeUser')['surname']);
            $boardModel->flush();
            $action = ($id != 0) ? "Board element with id: $id updated successfully." : "Board successfully added.";
            $this->tools->notification("Board element dodan/urejen.", "primary");
            $this->tools->log("board", $action);
        }
        $allItems = $boardModel->findAllSortedBy('id', 'desc', 20);
        $this->view->assign('items', $allItems);
        $this->view->assign('selectedBoard', $boardModel);
        $this->view->render("board/update");
    }
