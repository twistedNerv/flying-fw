<?php

class db extends PDO {

    public $link;
    public $result;
    public $numRows;

    function __construct() {
        parent::__construct(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    }

    public function getOneByParam($ident, $identValue, $table) {
        $columns = $this->getTableColumns($table);
        $val = $identValue;
        $sql = "SELECT " . implode(", ", $columns) . " FROM " . $table . " WHERE " . $ident . " = :" . $ident . ";";
        $this->result = $this->prepare($sql);
        $this->result->bindParam(':' . $ident, $val);
        $this->result->execute();
        $result = $this->result->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getAll($orderBy, $orderDirection, $limit, $table) {
        $columns = $this->getTableColumns($table);
        $sql = "SELECT " . implode(", ", $columns) . " FROM " . $table;
        if ($orderBy && $orderDirection) {
            $sql .= " ORDER BY " . $orderBy . " " . $orderDirection;
        }
        if ($limit) {
            $sql .= " LIMIT " . $limit;
        }
        $sql .= ";";
        $this->result = $this->prepare($sql);
        $this->result->execute();
        //echo "<pre>";$this->result->debugDumpParams();die;
        return $this->result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllByParam($ident, $identValue, $table, $orderby = null, $orderDirection = "ASC", $limit = null) {
        $columns = $this->getTableColumns($table);
        $val = $identValue;
        $sql = "SELECT " . implode(", ", $columns) . " FROM " . $table . " WHERE " . $ident . " = :" . $ident;
        if ($orderby) {
            $sql .= " ORDER BY " . $orderby . " " . $orderDirection;
        }
        if ($limit) {
            $sql .= " LIMIT " . $limit;
        }
        $sql .= ";";
        $this->result = $this->prepare($sql);
        $this->result->bindParam(':' . $ident, $val);
        $this->result->execute();
        $result = $this->result->fetchAll(PDO::FETCH_ASSOC);
        //echo "<pre>";$this->result->debugDumpParams();die;
        return $result;
    }

    public function delete(&$object, $table) {
        if ($id = $object->id) {
            $sql = "DELETE FROM " . $table . " WHERE id = :id";
            $this->result = $this->prepare($sql);
            $this->result->bindParam(':id', $object->id);
            $this->result->execute();
            $object->id = "";
        }
    }

    public function flush($object, $table, $sqlDump = 0) {
        $columns = $this->getTableColumns($table);
        $updArray = [];
        if (!$object->id) {
            unset($columns[0]);
            $sql = "INSERT INTO " . $table . " (" . implode(", ", $columns) . ") VALUES (:" . implode(", :", $columns) . ")";
            $this->result = $this->prepare($sql);
            foreach ($columns as $key => $value) {
                if ($value != "id") {
                    $updArray[':' . $value] = $object->$value;
                }
            }
        } else {
            $sql = "UPDATE " . $table . " SET ";
            foreach ($columns as $value) {
                $sql .= ($value != 'id') ? $value . " = :" . $value . ", " : "";
            }
            $sql = rtrim($sql, ", ");
            $sql .= " WHERE id = :id;";
            $this->result = $this->prepare($sql);
            foreach ($columns as $key => $value) {
                $updArray[':' . $value] = $object->$value;
            }
        }
        $this->result->execute($updArray);
        if ($sqlDump == 1) {
            echo "<pre>";
            $this->result->debugDumpParams();
            die;
        }
    }

    public function createTable($table) {
        $sql = file_get_contents("app/dbschemas/" . $table . ".sql");
        $this->result = $this->prepare($sql);
        $this->result->execute();
    }

    public function createSqlDump($table) {
        $sql = "SHOW CREATE TABLE :table";
        $this->result = $this->prepare($sql);
        $this->result->bindParam(':table', $table);
        $this->result->execute();
        $result = $this->result->fetch(PDO::FETCH_ASSOC);
        file_put_contents("app/dbschemas/" . $table . ".sql", $result['Create Table']);
    }

    public function tableExists($table) {
        $sql = "DESCRIBE :table";
        $this->result = $this->prepare($sql);
        $this->result->bindParam(':table', $table);
        $this->result->execute();
        $result = $this->result->fetch(PDO::FETCH_ASSOC);
        return ($result) ? 1 : 0;
    }

    public function getTables() {
        $sql = "SHOW TABLES;";
        $this->result = $this->prepare($sql);
        $this->result->execute();
        return array_column($this->result->fetchAll(PDO::FETCH_ASSOC), "Tables_in_" . APP_NAME);
    }

    public function getTableColumns($table, $details = false) {
        $sql = "SELECT COLUMN_NAME, COLUMN_TYPE
                FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_SCHEMA = '" . DB_DATABASE . "' AND TABLE_NAME = '" . $table . "';";
        $this->result = $this->prepare($sql);
        $this->result->execute();
        if (!$details) {
            return array_column($this->result->fetchAll(PDO::FETCH_ASSOC), "COLUMN_NAME");
        }
        return $this->result;
    }

}
