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
            echo "Create table $this->name not selected or table already exist. \n\r";
            if(!$this->sqlDumpCheck) {
                $this->createSqlDump();
                echo "Sql dump $this->name.sql created.\n\r";
            } else {
                echo "Create sql schema file $this->name.sql not selected or file already exist.\n\r";
            }
        } else {
            if($this->sqlDumpCheck) {
                $this->createTable();
                echo "Table $this->name created.\n\r";
            } else {
                echo "Can't create table, schema or model. DB table or file with sql schema doesn't exist.";
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
            echo "Create controller $this->name not selected or controller alerady exist.\n\r";
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
    
    private function checkCommand($argv) {
        if(!$argv[1]) {
            echo "Error: No package name selected.\nUse '[command] --help' for help.";
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
            echo "Error: No option selected.\nUse '[command] --help' for help.";
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
        $structure = '../app/views/default/' . $this->name . "/";
        if(!mkdir($structure, 0777, true)) {
            echo "Failed to create folder...";
        } else {
            file_put_contents("../app/views/default/" . $this->name . "/index.php", $fileString);
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