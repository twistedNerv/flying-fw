<?php

require_once '../app/core/db.php';
require_once '../app/config/globals.php';

class createModel extends db{
    
    public $db;
    public $name;
    public $tableCheck = 0;
    public $sqlDumpCheck = 0;
    public $controllerCheck = 0;
    public $viewCheck = 0;
    public $modelCheck = 0;
    public $columns = [];
    
    public function __construct($argv) {
        parent::__construct();
        $this->db = new db();
        $this->run($argv);
    }
    
    private function run($argv) {
        $this->checkCommand($argv);
        $this->tableCheck = ($this->tableCheck) ? $this->tableExist() : 0;
        $this->sqlDumpCheck = ($this->sqlDumpCheck) ? ((file_exists("../app/dbschemas/" . $this->name . ".sql")) ? 1 : 0) : 1;
        $this->modelCheck = ($this->modelCheck) ? ((file_exists("../app/models/" . $this->name . "Model.php")) ? 1 : 0) : 1;
        $this->controllerCheck = ($this->controllerCheck) ? ((file_exists("../app/controllers/" . $this->name . "Controller.php")) ? 1 : 0) : 1;
        $this->viewCheck = ($this->viewCheck) ? ((file_exists("../app/views/default/" . $this->name . "/index.php")) ? 1 : 0) : 1;
        
        if($this->tableCheck) {
            echo "Create table $this->name not selected or table already exists. \n\r";
            if(!$this->sqlDumpCheck) {
                $this->createSqlDump();
                echo "Sql dump $this->name.sql created.\n\r";
            } else {
                echo "Create sql schema file $this->name.sql not selected or file already exists.\n\r";
            }
        } else {
            if($this->sqlDumpCheck) {
                $this->createTable();
                echo "Table $this->name created.\n\r";
            } else {
                echo "Can't create table, schema or model (DB table or file with sql schema doesn't exists).\n\r";
                //return false;
            }
        }
        
        if($this->modelCheck || $this->tableExist() == 0) {
            echo "Create model $this->name not selected, model alerady exist or table doesn't exist.\n\r";
        } else {
            $this->columns = $this->db->getTableColumns($this->name);
            $this->createModel();
            echo "Model $this->name.php created.\n\r";
        }
        
        if($this->controllerCheck) {
            echo "Create controller $this->name not selected or controller alerady exists.\n\r";
        } else {
            $this->columns = $this->db->getTableColumns($this->name);
            $this->createController();
            echo "Controller $this->name.php created.\n\r";
        }
        
        if($this->viewCheck) {
            echo "View $this->name alerady exists.\n\r";
        } else {
            $this->createView();
            echo "View view/$this->name/index.php created.\n\r";
        }
    }
    
    private function checkCommand($argv) {
        if(!$argv[1]) {
            echo "Error: No package name selected.\nUse '[command] --help' for help.\n";
            die;
        }
        if($argv[1] == "--help") {
            echo "CREATE PACKAGE:\n";
            echo "[command/filename] [package name] --[option1] --[option2] ...\n\n";
            echo "Package name (mandatory):\n";
            echo '- limited charset [a-zA-Z0-9$_]';
            echo "\n\nOptions (at least one option is mandatory):\n";
            echo "--table (create db table from sql dump file if exist)\n";
            echo "--file (create sql dump file from db table)\n";
            echo "--controller (create and prepare controller file)\n";
            echo "--model (create and prepare model file)\n";
            echo "--view (create and prepare folders and view file)\n";
            echo "--all (all options included)\n";
            die;
        }
        if(preg_match('/^[a-zA-Z0-9$_]+$/', $argv[1]) != 1) {
            echo "\nError: Forbidden characters used for package name.\nUse '[command] --help' for help.\n";
            die;
        } 
        if(!$argv[2]) {
            echo "Error: No option selected.\nUse '[command] --help' for help.\n";
            die;
        }
        $this->name = $argv[1];
        unset($argv[0], $argv[1]);
        foreach($argv as $param) {
            switch($param) {
                case '--table':
                    $this->tableCheck = 1;
                    break;
                case '--file':
                    $this->sqlDumpCheck = 1;
                    break;
                case '--controller':
                    $this->controllerCheck = 1;
                    break;
                case '--model':
                    $this->modelCheck = 1;
                    break;
                case '--view':
                    $this->viewCheck = 1;
                    break;
                case '--all':
                    $this->tableCheck = $this->sqlDumpCheck = $this->controllerCheck = $this->modelCheck = $this->viewCheck = 1;
                    break;
                default:
                    echo "Wrong parameters.";
                    die;
            }
        }
    }
    
    private function createController() {
        $fileString = "<?php";
        $fileString .=  "\n\n";
        $fileString .= "class " . $this->name . "Controller extends controller {";
        $fileString .=  "\n\n";
        $fileString .= "\tpublic function __construct() { ";
        $fileString .= "\n";
        $fileString .= "\t\tparent::__construct();";
        $fileString .= "\n\t}";
        $fileString .= "\n\n\t";
        $fileString .= 'public function updateAction($id=0) {';
        $fileString .= "\n";
        $fileString .= "\t\t";
        $fileString .= '$' . $this->name . 'Model = $this->loadModel("' . $this->name . '");';
        $fileString .= "\n";
        $fileString .= "\t\t";
        $fileString .= 'if($id != 0) {';
        $fileString .= "\n";
        $fileString .= "\t\t\t";
        $fileString .= '$' . $this->name . 'Model->findOneById($id);';
        $fileString .= "\n";
        $fileString .= "\t\t";
        $fileString .= "}";
        $fileString .= "\n";
        $fileString .= "\t\t";
        $fileString .= 'if(isset($_POST["action"]) && $_POST["action"] == "handle' . $this->name . '") {';
        foreach($this->columns as $singleColumn) {
            $fileString .= "\n\t\t\t";
            $fileString .= '$' . $this->name . 'Model->set' . ucfirst($singleColumn) . '(filter_var($_POST["' . $this->name . '-' . $singleColumn . '"], FILTER_SANITIZE_STRING));';
        }
        $fileString .= "\n\t\t\t";
        $fileString .= '$' . $this->name . 'Model->flush();';
        $fileString .= "\n\t\t\t";
        $fileString .= '$action = ($id != 0) ? "' . ucfirst($this->name) . ' element with id: $id updated successfully." : "' . $this->name . ' successfully added.";';
        $fileString .= "\n\t\t\t";
        $fileString .= '$this->tools->notification("' . $this->name . ' element dodan/urejen.", "primary");';
        $fileString .= "\n\t\t\t";
        $fileString .= '$this->tools->log("' . $this->name . '", $action);';
        $fileString .= "\n\t\t";
        $fileString .= "}";
        $fileString .= "\n\t\t";
        $fileString .= '$allItems = $' . $this->name . 'Model->findAll();';
        $fileString .= "\n\t\t";
        $fileString .= '$this->view->render("' . $this->name . '/update", ["items" => $allItems, "selected' . ucfirst($this->name) . '" => $' . $this->name . 'Model]);';
        $fileString .= "\n\t";
        $fileString .= '}';
        $fileString .= "\n\n\t";
        $fileString .= 'public function removeAction($id) {';
        $fileString .= "\n\t\t";
        $fileString .= 'if ($id) {';
        $fileString .= "\n\t\t\t";
        $fileString .= '$' . $this->name . 'Model = $this->loadModel("' . $this->name . '");';
        $fileString .= "\n\t\t\t";
        $fileString .= '$' . $this->name . 'Model->findOneById($id);';
        $fileString .= "\n\t\t\t";
        $fileString .= '$' . $this->name . 'Model->remove();';
        $fileString .= "\n\t\t\t";
        $fileString .= '$this->tools->log("' . $this->name . '", "' . ucfirst($this->name) . ' element with id: $id removed.");';
        $fileString .= "\n\t\t\t";
        $fileString .= '$this->tools->redirect(URL . "' . $this->name . '/update");';
        $fileString .= "\n\t\t";
        $fileString .= '} else {';
        $fileString .= "\n\t\t\t";
        $fileString .= 'echo "No ' . $this->name . ' element id selected!";';
        $fileString .= "\n\t\t";
        $fileString .= '}';
        $fileString .= "\n\t";
        $fileString .= '}';
        $fileString .= "\n";
        $fileString .= '}';
        file_put_contents("../app/content/controllers/" . $this->name . "Controller.php", $fileString);
    }
    
    private function createModel() {
        $fileString = "<?php";
        $fileString .=  "\n\n";
        $fileString .= "class " . $this->name . "Model extends model {";
        $fileString .=  "\n\n";
        foreach($this->columns as $singleColumn) {
            $fileString .= "\tpublic $" . $singleColumn . ";\n";
        }
        $fileString .=  "\n\n";
        $fileString .= "\tpublic function __construct() { ";
        $fileString .= "\n";
        $fileString .= "\t\tparent::__construct();\n";
        $fileString .= "\t}";
        $fileString .= "\n\n";
        foreach($this->columns as $singleColumn) {
            $fileString .= "\tpublic function get" . ucfirst($singleColumn) . "() {\n";
            $fileString .= "\t\treturn $" . "this->" . $singleColumn . ";\n";
            $fileString .= "\t}\n\n";
            $fileString .= "\tpublic function set" . ucfirst($singleColumn) . "($" . $singleColumn . ") {\n";
            $fileString .= "\t\t$" . "this->" . $singleColumn . " = $" . $singleColumn . ";\n";
            $fileString .= "\t\treturn $". "this;\n";
            $fileString .= "\t}\n\n";
            $fileString .= "\tpublic function findOneBy" . ucfirst($singleColumn) . "($" . "value) {\n";
            $fileString .= "\t\t$" . "result = $" . "this->db->findOneByParam('" . $singleColumn . "', $" . "value, '" . $this->name . "');\n";
            $fileString .= "\t\t$" . "this->fill" . ucfirst($this->name) . "($" . "result);\n";
            $fileString .= "\t\treturn $" . "this;\n";
            $fileString .= "\t}\n\n";
        }
        $fileString .= "\tpublic function findAll() {\n";
        $fileString .= "\t\treturn $" . "this->db->findAll('" . $this->name . "');\n";
        $fileString .= "\t}";
        $fileString .= "\n\n";
        $fileString .= "\tpublic function flush($" . "sqlDump=0) {\n";
        $fileString .= "\t\t$" . "this->db->flush($" . "this, '" . $this->name . "', $" . "sqlDump);\n";
        $fileString .= "\t}";
        $fileString .= "\n\n";
        $fileString .= "\tpublic function remove() {\n";
        $fileString .= "\t\t$" . "this->db->delete($" . "this, '" . $this->name . "');\n";
        $fileString .= "\t}";
        $fileString .= "\n\n";
        $fileString .= "\tpublic function fill" . ucfirst($this->name) . "($" . "data) {\n";
        $fileString .= "\t\t$" . "columns = $" . "this->db->getTableColumns('" . $this->name . "');\n";
        $fileString .= "\t\tforeach($" . "data as $" . "key => $" . "value) {\n";
        $fileString .= "\t\t\t$" . "this->$" . "key = $" . "value;\n";
        $fileString .= "\t\t}\n";
        $fileString .= "\t\treturn $" . "this;\n";
        $fileString .= "\t}";
        $fileString .= "\n}";
        file_put_contents("../app/content/models/" . $this->name . "Model.php", $fileString);
    }
    
    private function createView() {
        $fileString = '<div class="col-sm-12 text-center">';
        $fileString .= "\n\t";
        $fileString .= '<h2>Nastavitve - ' . ucfirst($this->name) . '</h2>';
        $fileString .= "\n\t";
        $fileString .= '</div>';
        $fileString .= "\n";
        $fileString .= '<div class="col-sm-4 text-right">';
        $fileString .= "\n\t";
        $fileString .= '<div class="row">';
        $fileString .= "\n\t\t";
        $fileString .= '<div class="col-sm-12">';
        $fileString .= "\n\t\t\t";
        $fileString .= '<h4>' . ucfirst($this->name) . '</h4>';
        $fileString .= "\n\t\t";
        $fileString .= '</div>';
        
        
        
        $fileString .= "<br>\n";
        $fileString .= 'Data from controller: <?=$data["id"]?>';
        $structure = '../app/content/views/default/' . $this->name . "/";
        if(!mkdir($structure, 0777, true)) {
            echo "Failed to create folder...";
        } else {
            file_put_contents("../app/content/views/default/" . $this->name . "/index.php", $fileString);
        }
    }
    
    private function createTable() {
        $sql = file_get_contents("../app/dbschemas/" . $this->name . ".sql");
        $this->db->execute($sql);
    }
    
    private function createSqlDump() {
        $sql = "SHOW CREATE TABLE " . $this->name . ";";
        $result = $this->selectResult($sql);
        file_put_contents("../app/dbschemas/" . $this->name . ".sql", $result['Create Table']);
    }
    
    private function tableExist() {
        $sql = "DESCRIBE " . $this->name . ";";
        return ($this->selectResult($sql)) ? 1 : 0;
    }
 }

$newModel = new createModel($argv);
//echo $newModel->name;