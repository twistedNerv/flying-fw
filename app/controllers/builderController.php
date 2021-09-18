<?php

class builderController extends controller {

    public function __construct() {
        parent::__construct();
    }

    public function indexAction() {
        $builderModel = $this->loadModel('builder');
        $allSchemas = array_values(array_diff(scandir('app/dbschemas/'), ['.', '..', 'logs.sql', 'user.sql', 'menu.sql', 'actiongroup.sql', 'membership.sql']));
        $allTables = array_values(array_diff($builderModel->db->getTables(), ['logs', 'user', 'menu', 'actiongroup', 'membership']));
        $type = (isset($_POST['type']) && $_POST['type'] != "") ? $_POST['type'] : "";
        $status_desc = "";
        $table_name = "";
        
        if (isset($_POST['action']) && $_POST['action'] == "build" && $type) {
            if ($type == "create") {
                $table_name = (isset($_POST['create'])) ? $_POST['create'] : null;
                $status_desc .= "Table $table_name created<br>";
            } else {
                if ($type == "table") {
                    $table_name = (isset($_POST['tables'])) ? $_POST['tables'] : null;
                    $builderModel->db->createSqlDump($table_name);
                    $status_desc .= "Schema $table_name created<br>";
                } else if ($type == "schema") {
                    $table_name = (isset($_POST['schemas'])) ? $_POST['schemas'] : null;
                    $table_name = str_replace('.sql', '', $table_name);
                    $builderModel->db->createTable($table_name);
                    $status_desc .= "Table $table_name created<br>";
                } else {
                    $status_desc .= "No start option was chosen<br>";
                    die;
                }
            }
            $columns = $builderModel->db->getTableColumns($table_name);
            if (isset($_POST['wish-model']) && $_POST['wish-model'] == "1") {
                $this->createModel($table_name, $columns, $type);
                $status_desc .= "Class " . $table_name . "Model created<br>";
            }
            if (isset($_POST['wish-controller']) && $_POST['wish-controller'] == "1") {
                $this->createController($table_name, $columns, $type);
                $status_desc .= "Class " . $table_name . "Controller created<br>";
            }
            if (isset($_POST['wish-view-index']) && $_POST['wish-view-index'] == "1") {
                $this->createViewIndex($table_name);
                $builderModel->addToMenu($table_name, 'index', 1);
                $status_desc .= "View " . $table_name . "Update created and added in menu<br>";
            }
            if (isset($_POST['wish-view-update']) && $_POST['wish-view-update'] == "1") {
                $this->createViewUpdate($table_name, $columns);
                $position = (isset($_POST['wish-view-index']) && $_POST['wish-view-index'] == "1") ? 2 : 1;
                $builderModel->addToMenu($table_name, 'update', $position);
                $status_desc .= "View " . $table_name . "Update created and added in menu<br>";
            }
        }
        $this->view->assign('tables', $allTables);
        $this->view->assign('schemas', $allSchemas);
        $this->view->assign('status', $status_desc);
        $this->view->render('builder/index');
    }
    
    private function createViewUpdate($table, $columns=[]) {
        //echo "bčla";die;
        $structure = 'app/content/views/' . TEMPLATE . '/' . $table . "/";
        $filestring = file_get_contents('app/views/' . TEMPLATE . '/builder/templates/update.php');
        $inputs = "";
        foreach ($columns as $singleColumn) {
            if ($singleColumn != 'id') {
                $inputs .= "\n\t\t\t<div class='form-group'>\n";
                $inputs .= "\t\t\t\t<input type='text' class='form-control' name='" . $table . "-" . $singleColumn . "' placeholder='" . $singleColumn . "' value='<?php echo ($" . "data['selected" . ucfirst($table) . "']->$singleColumn) ? $" . "data['selected" . ucfirst($table) . "']->$singleColumn : ''; ?>'>\n";
                $inputs .= "\t\t\t</div>";
            }
        }
        $filestring = str_replace('[f[inputs]f]', $inputs, $filestring);
        $filestring = str_replace('[f[tablename]f]', $table, $filestring);
        $filestring = str_replace('[f[tablename_capital]f]', ucfirst($table), $filestring);
        if (!is_dir($structure)) {
            if (!mkdir($structure, 0777, true)) {
                echo "Failed to create folder...";
            }
        }
        file_put_contents($structure . 'update.php', $filestring);
    }
    
    private function createViewIndex($table) {
        $structure = 'app/content/views/' . TEMPLATE . '/' . $table . "/";
        $filestring = file_get_contents('app/views/' . TEMPLATE . '/builder/templates/index.php');
        $filestring = str_replace('[f[tablename]f]', $table, $filestring);
        $filestring = str_replace('[f[tablename_capital]f]', ucfirst($table), $filestring);
        if (!is_dir($structure)) {
            if(!mkdir($structure, 0777, true)) {
                echo "Failed to create folder...";
            }
        } 
        file_put_contents($structure . "index.php", $filestring);
    }
    
    private function createModel($table, $columns=[], $type='') {
        $fileString = "<?php";
        $fileString .=  "\n\n";
        $fileString .= "class " . $table . "Model extends model {";
        $fileString .=  "\n\n";
        foreach($columns as $singleColumn) {
            $fileString .= "\tpublic $" . $singleColumn . ";\n";
        }
        $fileString .=  "\n\n";
        $fileString .= "\tpublic function __construct() { ";
        $fileString .= "\n";
        $fileString .= "\t\tparent::__construct();\n";
        $fileString .= "\t}\n\n";
        if ($type != 'create') {
            foreach($columns as $singleColumn) {
                $fileString .= "\tpublic function get" . ucfirst($singleColumn) . "() {\n";
                $fileString .= "\t\treturn $" . "this->" . $singleColumn . ";\n";
                $fileString .= "\t}\n\n";
                $fileString .= "\tpublic function set" . ucfirst($singleColumn) . "($" . $singleColumn . ") {\n";
                $fileString .= "\t\t$" . "this->" . $singleColumn . " = $" . $singleColumn . ";\n";
                $fileString .= "\t\treturn $". "this;\n";
                $fileString .= "\t}\n\n";
            }
            $fileString .= "\tpublic function findOneBy($" . "ident, $" . "value) {\n";
            $fileString .= "\t\t$" . "result = $" . "this->db->findOneByParam($" . "ident, $" . "value, '" . $table . "');\n";
            $fileString .= "\t\t$" . "this->fill" . ucfirst($table) . "($" . "result);\n";
            $fileString .= "\t\treturn $". "this;\n";
            $fileString .= "\t}\n\n";
            $fileString .= "\tpublic function findAll($" . "orderBy = null, $" . "order = null, $" . "limit = null) {\n";
            $fileString .= "\t\treturn $" . "this->db->findAll($" . "orderBy, $" . "order, $" . "limit, '" . $table . "');\n";
            $fileString .= "\t}\n\n";
            $fileString .= "public function findAllBy($" . "ident, $" . "identVal, $" . "orderBy = null, $" . "orderDirection = 'ASC', $" . "limit=null) {\n";
            $fileString .= "return $" . "this->db->findAllByParam($" . "ident, $" . "identVal, '" . $table . "', $" . "orderBy, $" . "orderDirection, $" . "limit);\n";
            $fileString .= "\t}\n\n";
            $fileString .= "\tpublic function flush($" . "sqlDump=0) {\n";
            $fileString .= "\t\t$" . "this->db->flush($" . "this, '" . $table . "', $" . "sqlDump);\n";
            $fileString .= "\t}\n\n";
            $fileString .= "\tpublic function remove() {\n";
            $fileString .= "\t\t$" . "this->db->delete($" . "this, '" . $table . "');\n";
            $fileString .= "\t}\n\n";
            $fileString .= "\tpublic function fill" . ucfirst($table) . "($" . "data) {\n";
            $fileString .= "\t\t$" . "columns = $" . "this->db->getTableColumns('" . $table . "');\n";
            $fileString .= "\t\tforeach($" . "data as $" . "key => $" . "value) {\n";
            $fileString .= "\t\t\t$" . "this->$" . "key = $" . "value;\n";
            $fileString .= "\t\t}\n";
            $fileString .= "\t\treturn $" . "this;\n";
            $fileString .= "\t}";
        }
        $fileString .= "\n}";
        file_put_contents("app/content/models/" . $table . "Model.php", $fileString);
    }
    
    private function createController($table, $columns=[], $type='') {
        $fileString = "<?php";
        $fileString .=  "\n\n";
        $fileString .= "class " . $table . "Controller extends controller {";
        $fileString .=  "\n\n";
        $fileString .= "\tpublic function __construct() { ";
        $fileString .= "\n";
        $fileString .= "\t\tparent::__construct();";
        $fileString .= "\n\t}";
        $fileString .= "\n\n\t";
        $fileString .= 'public function indexAction($id=0) {';
        $fileString .= "\n\t\t";
        $fileString .= "$" . $table . "Model = $" . "this->loadModel('" . $table . "');";
        $fileString .= "\n";
        $fileString .= "\t\t";
        $fileString .= "$" . $table . "Obj = $" . $table . "Model->findAll();";
        $fileString .= "\n";
        $fileString .= "\t\t";
        $fileString .= "$" . "this->view->assign('vars', get_class_vars('" . $table . "Model'));";
        $fileString .= "\n";
        $fileString .= "\t\t";
        $fileString .= "$" . "this->view->assign('items', $" . $table . "Obj);";
        $fileString .= "\n";
        $fileString .= "\t\t";
        $fileString .= '$this->view->render("' . $table . '/index");';
        $fileString .= "\n\t";
        $fileString .= '}';
        if ($type != 'create') {
            $fileString .= "\n\n\t";
            $fileString .= 'public function updateAction($id=0) {';
            $fileString .= "\n";
            $fileString .= "\t\t";
            $fileString .= "$" . "this->tools->checkPageRights(4);";
            $fileString .= "\n";
            $fileString .= "\t\t";
            $fileString .= '$' . $table . 'Model = $this->loadModel("' . $table . '");';
            $fileString .= "\n";
            $fileString .= "\t\t";
            $fileString .= 'if($id != 0) {';
            $fileString .= "\n";
            $fileString .= "\t\t\t";
            $fileString .= '$' . $table . 'Model->findOneBy("id", $id);';
            $fileString .= "\n";
            $fileString .= "\t\t";
            $fileString .= "}";
            $fileString .= "\n";
            $fileString .= "\t\t";
            $fileString .= 'if(isset($_POST["action"]) && $_POST["action"] == "handle' . $table . '") {';
            foreach($columns as $singleColumn) {
                if ($singleColumn != 'id') {
                    $fileString .= "\n\t\t\t";
                    $fileString .= '$' . $table . 'Model->set' . ucfirst($singleColumn) . '($this->tools->sanitizePost($_POST["' . $table . '-' . $singleColumn . '"]));';
                }
            }
            $fileString .= "\n\t\t\t";
            $fileString .= '$' . $table . 'Model->flush();';
            $fileString .= "\n\t\t\t";
            $fileString .= '$action = ($id != 0) ? "' . ucfirst($table) . ' element with id: $id updated successfully." : "' . $table . ' successfully added.";';
            $fileString .= "\n\t\t\t";
            $fileString .= '$this->tools->notification("' . $table . ' element dodan/urejen.", "primary");';
            $fileString .= "\n\t\t\t";
            $fileString .= '$this->tools->log("' . $table . '", $action);';
            $fileString .= "\n\t\t\t";
            $fileString .= "if ($" . "id == 0)";
            $fileString .= "\n\t\t\t\t";
            $fileString .= '$this->tools->redirect(URL . "' . $table . '/update");';
            $fileString .= "\n\t\t";
            $fileString .= "}";
            $fileString .= "\n\t\t";
            $fileString .= '$allItems = $' . $table . 'Model->findAll();';
            $fileString .= "\n\t\t";
            $fileString .= '$this->view->assign("items", $allItems);';
            $fileString .= "\n\t\t";
            $fileString .= '$this->view->assign("selected' . ucfirst($table) . '", $' . $table . 'Model);';
            $fileString .= "\n\t\t";
            $fileString .= '$this->view->render("' . $table . '/update");';
            $fileString .= "\n\t";
            $fileString .= '}';
            $fileString .= "\n\n\t";
            $fileString .= 'public function removeAction($id) {';
            $fileString .= "\n\t\t";
            $fileString .= 'if ($id) {';
            $fileString .= "\n\t\t\t";
            $fileString .= '$' . $table . 'Model = $this->loadModel("' . $table . '");';
            $fileString .= "\n\t\t\t";
            $fileString .= '$' . $table . 'Model->findOneBy("id", $id);';
            $fileString .= "\n\t\t\t";
            $fileString .= '$' . $table . 'Model->remove();';
            $fileString .= "\n\t\t\t";
            $fileString .= '$this->tools->log("' . $table . '", "' . ucfirst($table) . ' element with id: $id removed.");';
            $fileString .= "\n\t\t\t";
            $fileString .= '$this->tools->redirect(URL . "' . $table . '/update");';
            $fileString .= "\n\t\t";
            $fileString .= '} else {';
            $fileString .= "\n\t\t\t";
            $fileString .= 'echo "No ' . $table . ' element id selected!";';
            $fileString .= "\n\t\t";
            $fileString .= '}';
            $fileString .= "\n\t";
            $fileString .= '}';
        }
        $fileString .= "\n";
        $fileString .= '}';
        file_put_contents("app/content/controllers/" . $table . "Controller.php", $fileString);
    }
}
