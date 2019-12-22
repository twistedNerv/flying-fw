<?php
class db extends PDO {
    public $link;
    public $result;
    public $numRows;
    
    function __construct() {
        parent::__construct(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    }
    
    public function selectResult($sql) {
        $this->result = $this->prepare($sql);
        $this->result->execute();
        return $this->result->fetch(PDO::FETCH_ASSOC);
    }
    
    public function selectAllResults($sql) {
        $this->result = $this->prepare($sql);
        $this->result->execute();
        return $this->result->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function execute($sql) {
        $this->result = $this->prepare($sql);
        $this->result->execute();
    }
    
    public function findOneByParam($ident, $identValue, $table) {
        $columns = $this->getTableColumns($table);
        $val = $identValue;
        $sql = "SELECT " . implode(", ", $columns) . " FROM " . $table . " WHERE " . $ident . " = :" . $ident . ";";
        $this->result = $this->prepare($sql);
        $this->result->bindParam(':'.$ident, $val);
        $this->result->execute();
        $result = $this->result->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    
    public function findAll($table) {
        $columns = $this->getTableColumns($table);
        $sql = "SELECT " . implode(", ", $columns) . " FROM " . $table . ";";
        $this->result = $this->prepare($sql);
        $this->result->execute();
        //echo "<pre>";$this->result->debugDumpParams();die;
        return $this->result->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function findAllSortedLimited($table, $orderBy, $order, $limit) {
        $columns = $this->getTableColumns($table);
        $sql = "SELECT " . implode(", ", $columns) . " FROM " . $table . " ORDER BY " . $orderBy . " " . $order . " LIMIT " . $limit . ";";
        $this->result = $this->prepare($sql);
        $this->result->execute();
        //echo "<pre>";$this->result->debugDumpParams();die;
        return $this->result->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function delete(&$object, $table) {
        if($id = $object->id) {
            $sql = "DELETE FROM " . $table . " WHERE id = :id";
            $this->result = $this->prepare($sql);
            $this->result->bindParam(':id', $object->id);
            $this->result->execute();
            $object->id = "";
        }
    }
    
    public function flush($object, $table) {
        $columns = $this->getTableColumns($table);
        $updArray = [];
        if(!$object->id) {
            unset($columns[0]);
            $sql = "INSERT INTO " . $table . " (" . implode(", ", $columns) . ") VALUES (:" . implode(", :", $columns) . ")";
            $this->result = $this->prepare($sql);
            foreach($columns as $key => $value){
                if($value != "id") {
                    $updArray[':'.$value] = $object->$value;
                }
            }
        } else {
            $sql = "UPDATE " . $table . " SET ";
            foreach($columns as $value){
                $sql .= ($value != 'id') ? $value . " = :" . $value . ", " : "";
            }
            $sql = rtrim($sql, ", ");
            $sql .= " WHERE id = :id;";
            $this->result = $this->prepare($sql);
            foreach($columns as $key => $value){
                $updArray[':'.$value] = $object->$value;
            }
        }
        $this->result->execute($updArray);
        //echo "<pre>";$this->result->debugDumpParams();die;
    }
    
    public function getTableColumns($table) {
        $sql = "SELECT COLUMN_NAME
                FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_SCHEMA = '" . DB_DATABASE . "' AND TABLE_NAME = '" . $table . "';";
        $result = $this->selectAllResults($sql);
        $val = "";
        foreach($result as $singleColumn) {
            $val .= $singleColumn['COLUMN_NAME'] . ",";
        }
        $val = rtrim($val,",");
        $columnArray = explode(",", $val);
        return $columnArray;
    }
}