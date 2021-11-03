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
        $title = $displayActionName . " " . $table;
        $description = $displayActionDesc . " " . $table;
        $url = $table . "/" . $filename;
        $sql = "INSERT INTO `menu` (`title`, `description`, `url`, `level`, `position`, `parent`, `active`, `admin`) VALUES ";
        $sql .= "(:title, :description, :url, 2, :position, 0, 1, 0);";
        $this->db->result = $this->db->prepare($sql);
        $this->db->result->bindParam(':title', $title);
        $this->db->result->bindParam(':description', $description);
        $this->db->result->bindParam(':url', $url);
        $this->db->result->bindParam(':position', $position);
        $this->db->result->execute();
    }
}