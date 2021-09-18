<?php

class builderModel extends model {

    public function __construct() {
        parent::__construct();
    }
    
    public function addToMenu($table, $filename, $position) {
        switch($filename) {
            case 'index':
                $displayActionName = 'View';
                $displayActionDesc = 'Here you can view';
                break;
            case 'update':
                $displayActionName = 'Edit';
                $displayActionDesc = 'Here you can edit';
                break;
        }
        $sql = "INSERT INTO `menu` (`title`, `description`, `url`, `level`, `position`, `parent`, `active`, `admin`) VALUES ";
        $sql .= "('" . $displayActionName . " " . $table . "', '" . $displayActionDesc . " " . $table . "', '" . $table . "/" . $filename . "', 2, " . $position . ", 0, 1, 0);";
        $this->db->execute($sql);
    }
}