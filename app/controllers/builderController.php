<?php

class builderController extends controller {

    public function __construct() {
        parent::__construct();
        $this->tools->checkPageRights(4);
    }
    
    private function getAvailableTables($object) {
        return array_values(array_diff($object->db->getTables(), ['logs', 'user', 'menu', 'actiongroup', 'membership']));
    }

    public function indexAction() {
        $builderModel = $this->loadModel('builder');
        $allSchemas = array_values(array_diff(scandir('app/dbschemas/'), ['.', '..', 'logs.sql', 'user.sql', 'menu.sql', 'actiongroup.sql', 'membership.sql']));
        $allTables = $this->getAvailableTables($builderModel);
        $type = ($this->tools->getPost('type')) ? $this->tools->getPost('type') : "";
        $status_desc = "";
        $table_name = "";

        if ($this->tools->getPost('action') == "build" && $type) {
            if ($type == "create") {
                $table_name = $this->tools->getPost('create');
                $status_desc .= "Table $table_name created<br>";
            } else {
                if ($type == "table") {
                    $table_name = $this->tools->getPost('tables');
                    $builderModel->db->createSqlDump($table_name);
                    $status_desc .= "Schema $table_name created<br>";
                } else if ($type == "schema") {
                    $table_name = $this->tools->getPost('schemas');
                    $table_name = str_replace('.sql', '', $table_name);
                    $builderModel->db->createTable($table_name);
                    $status_desc .= "Table $table_name created<br>";
                } else {
                    $status_desc .= "No start option was chosen<br>";
                    die;
                }
            }
            $columns = $builderModel->db->getTableColumns($table_name);
            if ($this->tools->getPost('wish-model') == "1") {
                $this->createModel($table_name, $columns, $type);
                $status_desc .= "Class " . $table_name . "Model created<br>";
            }
            if ($this->tools->getPost('wish-controller') == "1") {
                $this->createController($table_name, $columns, $type);
                $status_desc .= "Class " . $table_name . "Controller created<br>";
            }
            if ($this->tools->getPost('wish-view-index') == "1") {
                $this->createViewIndex($table_name);
                $builderModel->addToMenu($table_name, 'index', 1);
                $status_desc .= "View " . $table_name . "Index created and added in menu<br>";
            }
            if ($this->tools->getPost('wish-view-update') == "1") {
                $this->createViewUpdate($table_name, $columns);
                $position = ($this->tools->getPost('wish-view-index') == "1") ? 2 : 1;
                $builderModel->addToMenu($table_name, $table_name . ' update', $position);
                $status_desc .= "View " . $table_name . "Update created and added in menu<br>";
            }
            if ($this->tools->getPost('wish-view-pack') == "1") {
                $this->createViewUpdate($table_name, $columns);
                $position = $this->tools->getPost('wish-view-index') + $this->tools->getPost('wish-view-update') + 1;
                $builderModel->addToMenu($table_name, $table_name . ' update', $position);
                $status_desc .= "View " . $table_name . "Update created and added in menu<br>";
            }
        }
        $this->view->assign('tables', $allTables);
        $this->view->assign('schemas', $allSchemas);
        $this->view->assign('status', $status_desc);
        $this->view->render('builder/index');
    }
    
    public function formAction($table = null) {
        if ($table) {
            $this->createViewUpdateCustom($table);
        } else {
            $this->chooseTableToCreateForm();
        }
    }
    
    private function chooseTableToCreateForm() {
        $builderModel = $this->loadModel('builder');
        $columns = $this->getAvailableTables($builderModel);
        $collection = [];
        foreach ($columns as $single_column) {
            $menuModel = $this->loadModel('menu');
            $collection[$single_column]['controller'] = (file_exists('app/content/controllers/' . $single_column . 'Controller.php')) ? true : false;
            $collection[$single_column]['model'] = (file_exists('app/content/models/' . $single_column . 'Model.php')) ? true : false;
            $collection[$single_column]['view_index'] = (file_exists('app/content/views/' . TEMPLATE . '/' . $single_column . '/index.php')) ? true : false;
            $collection[$single_column]['view'] = (file_exists('app/content/views/' . TEMPLATE . '/' . $single_column . '/update.php')) ? true : false;
            $collection[$single_column]['menu'] = ($menuModel->getOneBy('url', $single_column . '/update')->url) ? true : false;
        }
        $this->view->assign('collection', $collection);
        $this->view->render('builder/chooseTableToCreateForm');
        //var_dump($collection);
    }

    private function createViewUpdateCustom($table) {
        $builderModel = $this->loadModel('builder');
        $columns = $builderModel->db->getTableColumns($table);
        if ($this->tools->getPost('action') == "create-view-update-custom") {
            $structure = 'app/content/views/' . TEMPLATE . '/' . $table . "/";
            $filestring = file_get_contents('app/views/' . TEMPLATE . '/builder/templates/update.php');
            $inputs = "";
            $include_editor = "";
            foreach ($columns as $singleColumn) {
                $name_root = $table . "-" . $singleColumn;
                $type = $this->tools->getPost($name_root . "-type");
                $attr_name = " name='" . $name_root . "'";
                $attr_id = " id='" . $name_root . "'";
                $attr_placeholder = " placeholder='" . $this->tools->getPost($name_root . "-placeholder") . "'";
                $attr_basic_value = " value='<?php echo ($" . "data['selected" . ucfirst($table) . "']->$singleColumn) ? $" . "data['selected" . ucfirst($table) . "']->$singleColumn : ''; ?>'";
                $attr_basic_value_textarea = "<?php echo ($" . "data['selected" . ucfirst($table) . "']->$singleColumn) ? $" . "data['selected" . ucfirst($table) . "']->$singleColumn : ''; ?>";
                $required = ($this->tools->getPost($name_root . "-required") == 1) ? " required" : "";
                $readonly = ($this->tools->getPost($name_root . "-readonly") == 1) ? " readonly" : "";
                $disabled = ($this->tools->getPost($name_root . "-disabled") == 1) ? " disabled" : "";
                if ($type != "" && $singleColumn != 'id') {
                    $inputs .= "\n\t\t<div class='form-group'>\n";
                    $inputs .= "\t\t\t<label for='" . $name_root . "'>" . $this->tools->getPost($name_root . '-label') . "</label>\n";
                    switch ($type) {
                        case 'text':
                            $inputs .= "\t\t\t<input type='text' class='form-control'" . $attr_name . $attr_id . $attr_placeholder . $attr_basic_value . $required . $readonly . $disabled . ">\n";
                            break;
                        case 'password':
                            $inputs .= "\t\t\t<input type='password' class='form-control'" . $attr_name . $attr_id . $attr_placeholder . $attr_basic_value . $required . $readonly . $disabled . ">\n";
                            break;
                        case 'number':
                            $inputs .= "\t\t\t<input type='number' class='form-control'" . $attr_name . $attr_id . $attr_placeholder . $attr_basic_value . $required . $readonly . $disabled . ">\n";
                            break;
                        case 'textarea':
                            $inputs .= "\t\t\t<textarea class='form-control'" . $attr_name . $attr_id . $attr_placeholder . $required . $readonly . $disabled . ">" . trim($attr_basic_value_textarea) . "</textarea>\n";
                            break;
                        case 'editor':
                            $inputs .= "\t\t\t<textarea class='form-control easy-edit-me'" . $attr_name . $attr_id . $attr_placeholder . $required . $readonly . $disabled . ">" . trim($attr_basic_value_textarea) . "</textarea>\n";
                            $include_editor .= "\n\t\tnew EasyEditor('#" . $name_root . "');";
                            break;
                        case 'email':
                            $inputs .= "\t\t\t<input type='email' class='form-control'" . $attr_name . $attr_id . $attr_placeholder . $attr_basic_value . $required . $readonly . $disabled . ">\n";
                            break;
                        case 'date':
                            $inputs .= "\t\t\t<input type='date' class='form-control'" . $attr_name . $attr_id . $attr_placeholder . $attr_basic_value . $required . $readonly . $disabled . ">\n";
                            break;
                        case 'select':
                            $inputs .= "\t\t\t<select class='form-control'" . $attr_name . $attr_id . $required . $readonly . $disabled . ">\n";
                            $inputs .= "\t\t\t\t<option value='first' <?php echo ($" . "data['selected" . ucfirst($table) . "']->$singleColumn == 'first') ? 'selected' : '' ?>>First choice</option>\n";
                            $inputs .= "\t\t\t\t<option value='second' <?php echo ($" . "data['selected" . ucfirst($table) . "']->$singleColumn == 'second') ? 'selected' : '' ?>>Second choice</option>\n";
                            $inputs .= "\t\t\t</select>\n";
                            break;
                        case 'radio':
                            $inputs .= "\t\t\t<input type='radio' class='form-control'" . $attr_name . " id='" . $name_root . "-first'" . " value='first'" . $required . $readonly . $disabled . " <?php echo ($" . "data['selected" . ucfirst($table) . "']->$singleColumn == 'first') ? 'checked' : '';?>>\n";
                            $inputs .= "\t\t\t<label for='" . $name_root . "-first'>First</label>\n"; 
                            $inputs .= "\t\t\t<input type='radio' class='form-control'" . $attr_name . " id='" . $name_root . "-second'" . " value='second'" . $required . $readonly . $disabled . " <?php echo ($" . "data['selected" . ucfirst($table) . "']->$singleColumn == 'second') ? 'checked' : '';?>>\n";
                            $inputs .= "\t\t\t<label for='" . $name_root . "-second'>Second</label>\n"; 
                            break;
                        case 'checkbox':
                            $inputs .= "\t\t\t<input type='hidden'" . $attr_name . "  value='0'>\n";
                            $inputs .= "\t\t\t<input type='checkbox' class='form-control'" . $attr_name . " value='1' <?php echo ($" . "data['selected" . ucfirst($table) . "']->$singleColumn == 1) ? 'checked' : '';?>>\n";
                            break;
                        case 'color':
                            $inputs .= "\t\t\t<input type='color' class='form-control'" . $attr_name . $attr_id . $attr_placeholder . $attr_basic_value . $required . $readonly . $disabled . ">\n";
                            break;
                    }
                    $inputs .= "\t\t</div>";
                }
            }
            $include_editor = ($include_editor != "") ? "<script>jQuery(document).ready(function () { " . $include_editor . "\n\t});</script>" : "";
            $filestring = str_replace('[f[inputs]f]', $inputs, $filestring);
            $filestring = str_replace('[f[tablename]f]', $table, $filestring);
            $filestring = str_replace('[f[tablename_capital]f]', ucfirst($table), $filestring);
            $filestring = str_replace('[f[js_editor]f]', $include_editor, $filestring);

            if (!is_dir($structure)) {
                if (!mkdir($structure, 0777, true)) {
                    echo "Failed to create folder...";
                }
            }
            //file_put_contents($structure . 'update.php', $filestring);
            $this->createViewIndexCustom($table);
        }

        $this->view->assign('table', $table);
        $this->view->assign('columns', $columns);
        $this->view->render('builder/createViewUpdateCustom', $columns);
    }

    private function createViewUpdate($table, $columns = []) {
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

    private function createViewIndexCustom($table) {
        $builderModel = $this->loadModel('builder');
        $columns = $builderModel->db->getTableColumns($table);
        
        $structure = 'app/content/views/' . TEMPLATE . '/' . $table . "/";
        $filestring = file_get_contents('app/views/' . TEMPLATE . '/builder/templates/index.php');
        $head_inputs = "";
        $inputs = "";
        foreach ($columns as $singleColumn) {
            $name_root = $table . "-" . $singleColumn;
            if ($this->tools->getPost($name_root . "-viewdisplay") == 1) {
                $head_inputs .= "\n\t\t<td><h5c>" . $singleColumn . "</h5c></td>";
                $inputs .= "\n\t\t<td><?= $" . "singleItem['" . $singleColumn . "'] ?></td>";
            }
        }
        $filestring = str_replace('[f[tablename_capital]f]', ucfirst($table), $filestring);
        $filestring = str_replace('[f[head_inputs]f]', $head_inputs, $filestring);
        $filestring = str_replace('[f[inputs]f]', $inputs, $filestring);
        if (!is_dir($structure)) {
            if (!mkdir($structure, 0777, true)) {
                echo "Failed to create folder...";
            }
        }
        file_put_contents($structure . "index.php", $filestring);
    }
    
    private function createViewIndex($table) {
        $structure = 'app/content/views/' . TEMPLATE . '/' . $table . "/";
        $filestring = file_get_contents('app/views/' . TEMPLATE . '/builder/templates/index.php');
        $filestring = str_replace('[f[tablename]f]', $table, $filestring);
        $filestring = str_replace('[f[tablename_capital]f]', ucfirst($table), $filestring);
        if (!is_dir($structure)) {
            if (!mkdir($structure, 0777, true)) {
                echo "Failed to create folder...";
            }
        }
        file_put_contents($structure . "index.php", $filestring);
    }

    private function createModel($table, $columns = [], $type = '') {
        $fileString = "<?php";
        $fileString .= "\n\n";
        $fileString .= "class " . $table . "Model extends model {";
        $fileString .= "\n\n";
        foreach ($columns as $singleColumn) {
            $fileString .= "\tpublic $" . $singleColumn . ";\n";
        }
        $fileString .= "\n\n";
        $fileString .= "\tpublic function __construct() { ";
        $fileString .= "\n";
        $fileString .= "\t\tparent::__construct();\n";
        $fileString .= "\t}\n\n";
        if ($type != 'create') {
            foreach ($columns as $singleColumn) {
                $fileString .= "\tpublic function get" . ucfirst($singleColumn) . "() {\n";
                $fileString .= "\t\treturn $" . "this->" . $singleColumn . ";\n";
                $fileString .= "\t}\n\n";
                $fileString .= "\tpublic function set" . ucfirst($singleColumn) . "($" . $singleColumn . ") {\n";
                $fileString .= "\t\t$" . "this->" . $singleColumn . " = $" . $singleColumn . ";\n";
                $fileString .= "\t\treturn $" . "this;\n";
                $fileString .= "\t}\n\n";
            }
            $fileString .= "\tpublic function getOneBy($" . "ident, $" . "value) {\n";
            $fileString .= "\t\t$" . "result = $" . "this->db->getOneByParam($" . "ident, $" . "value, '" . $table . "');\n";
            $fileString .= "\t\t$" . "this->fillObject('" . $table . "', $" . "result);\n";
            $fileString .= "\t\treturn $" . "this;\n";
            $fileString .= "\t}\n\n";
            $fileString .= "\tpublic function getAll($" . "orderBy = null, $" . "order = null, $" . "limit = null) {\n";
            $fileString .= "\t\treturn $" . "this->db->getAll($" . "orderBy, $" . "order, $" . "limit, '" . $table . "');\n";
            $fileString .= "\t}\n\n";
            $fileString .= "public function getAllBy($" . "ident, $" . "identVal, $" . "orderBy = null, $" . "orderDirection = 'ASC', $" . "limit=null) {\n";
            $fileString .= "return $" . "this->db->getAllByParam($" . "ident, $" . "identVal, '" . $table . "', $" . "orderBy, $" . "orderDirection, $" . "limit);\n";
            $fileString .= "\t}\n\n";
            $fileString .= "\tpublic function flush($" . "sqlDump=0) {\n";
            $fileString .= "\t\t$" . "this->db->flush($" . "this, '" . $table . "', $" . "sqlDump);\n";
            $fileString .= "\t}\n\n";
            $fileString .= "\tpublic function remove() {\n";
            $fileString .= "\t\t$" . "this->db->delete($" . "this, '" . $table . "');\n";
            $fileString .= "\t}\n\n";
        }
        $fileString .= "\n}";
        file_put_contents("app/content/models/" . $table . "Model.php", $fileString);
    }

    private function createController($table, $columns = [], $type = '') {
        $fileString = "<?php";
        $fileString .= "\n\n";
        $fileString .= "class " . $table . "Controller extends controller {";
        $fileString .= "\n\n";
        $fileString .= "\tpublic function __construct() { ";
        $fileString .= "\n";
        $fileString .= "\t\tparent::__construct();";
        $fileString .= "\n\t}";
        $fileString .= "\n\n\t";
        if ($type != 'create') {
            $fileString .= 'public function indexAction($id=0) {';
            $fileString .= "\n\t\t";
            $fileString .= "$" . $table . "Model = $" . "this->loadModel('" . $table . "');";
            $fileString .= "\n";
            $fileString .= "\t\t";
            $fileString .= "$" . $table . "Obj = $" . $table . "Model->getAll();";
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
            $fileString .= '$' . $table . 'Model->getOneBy("id", $id);';
            $fileString .= "\n";
            $fileString .= "\t\t";
            $fileString .= "}";
            $fileString .= "\n";
            $fileString .= "\t\t";
            $fileString .= 'if($this->tools->getPost("action") == "handle' . $table . '") {';
            foreach ($columns as $singleColumn) {
                if ($singleColumn != 'id') {
                    $fileString .= "\n\t\t\t";
                    $fileString .= '$' . $table . 'Model->set' . ucfirst($singleColumn) . '($this->tools->getPost("' . $table . '-' . $singleColumn . '"));';
                }
            }
            $fileString .= "\n\t\t\t";
            $fileString .= '$' . $table . 'Model->flush();';
            $fileString .= "\n\t\t\t";
            $fileString .= '$action = ($id != 0) ? "' . ucfirst($table) . ' element with id: $id updated successfully." : "' . $table . ' successfully added.";';
            $fileString .= "\n\t\t\t";
            $fileString .= '$this->tools->log("' . $table . '", $action);';
            $fileString .= "\n\t\t\t";
            $fileString .= "if ($" . "id == 0)";
            $fileString .= "\n\t\t\t\t";
            $fileString .= '$this->tools->redirect(URL . "' . $table . '/update");';
            $fileString .= "\n\t\t";
            $fileString .= "}";
            $fileString .= "\n\t\t";
            $fileString .= '$allItems = $' . $table . 'Model->getAll();';
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
            $fileString .= '$' . $table . 'Model->getOneBy("id", $id);';
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
