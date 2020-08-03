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
        $this->name = $argv[1];
        $this->run();
    }
    
    private function run() {
        $this->tableCheck = $this->tableExist();
        $this->sqlDumpCheck = (file_exists("../app/dbschemas/" . $this->name . ".sql")) ? 1 : 0;
        $this->modelCheck = (file_exists("../app/models/" . $this->name . "Model.php")) ? 1 : 0;
        $this->controllerCheck = (file_exists("../app/controllers/" . $this->name . "Controller.php")) ? 1 : 0;
        $this->viewCheck = (file_exists("../app/views/" . TEMPLATE . "/" . $this->name . "/index.php")) ? 1 : 0;
        
        if($this->tableCheck) {
            echo "Table $this->name already exist. \n\r";
            if(!$this->sqlDumpCheck) {
                $this->createSqlDump();
                echo "Sql dump $this->name.sql created.\n\r";
            } else {
                echo "Sql schema file $this->name already exist. \n\r";
            }
        } else {
            if($this->sqlDumpCheck) {
                $this->createTable();
                echo "Table $this->name created.\n\r";
            } else {
                echo "DB table or file with schema doesn't exist. Can't create model.";
                return false;
            }
        }
        
        if($this->modelCheck) {
            echo "Model $this->name alerady exist.\n\r";
        } else {
            $this->columns = $this->db->getTableColumns($this->name);
            $this->createModel();
            echo "Model $this->name.php created.\n\r";
        }
        
        if($this->controllerCheck) {
            echo "Controller $this->name alerady exist.\n\r";
        } else {
            $this->createController();
            echo "Controller $this->name.php created.\n\r";
        }
        
        if($this->viewCheck) {
            echo "View $this->name alerady exist.\n\r";
        } else {
            $this->createView();
            echo "View view/$this->name/index.php created.\n\r";
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
        $fileString .= "\n\n";
        $fileString .= "\tpublic function index() {";
        $fileString .= "\n";
        $fileString .= "\t\t";
        $fileString .= '/*$' . $this->name . 'Model = $this->loadModel("' . $this->name . '");';
        $fileString .= "\n";
        $fileString .= "\t\t";
        $fileString .= '$' . $this->name . 'Model->findOneById(1);';
        $fileString .= "\n";
        $fileString .= "\t\t";
        $fileString .= '$' . $this->name . 'Model->name = "test";';
        $fileString .= "\n";
        $fileString .= "\t\t";
        $fileString .= '$' . $this->name . 'Model->flush();';
        $fileString .= "\n";
        $fileString .= "\t\t";
        $fileString .= '$' . $this->name . 'Model->remove();';
        $fileString .= "\n";
        $fileString .= "\t\t";
        $fileString .= '$' . $this->name . 'Model->flush();';
        $fileString .= "\n";
        $fileString .= "\t\t$" . "this->view->render('" . $this->name . "/index', ['name' => $" . $this->name . "Model->name]);*/";
        $fileString .= "\n\t}";
        $fileString .= "\n\n}";
        file_put_contents("../app/controllers/" . $this->name . "Controller.php", $fileString);
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
        $fileString .= "\tpublic function flush() {\n";
        $fileString .= "\t\t$" . "this->db->flush($" . "this, '" . $this->name . "');\n";
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
        file_put_contents("../app/models/" . $this->name . "Model.php", $fileString);
    }
    
    private function createView() {
        $fileString = "<h3>This is autogenerated text.</h3>\n";
        $fileString .= "<br>\n";
        $fileString .= 'Data from controller: <?=$data["id"]?>';
        $structure = '../app/views/' . TEMPLATE . '/' . $this->name . "/";
        if(!mkdir($structure, 0777, true)) {
            echo "Failed to create folder...";
        } else {
            file_put_contents("../app/views/" . TEMPLATE . "/" . $this->name . "/index.php", $fileString);
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