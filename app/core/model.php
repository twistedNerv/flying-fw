<?php

class model {

    public function __construct() {
        $this->db = new db();
        $this->tools = new tools;
    }
    
    public function fillObject($model_name, $data) {
        if ($model_name && (is_array($data) || is_object($data))) {
            $columns = $this->db->getTableColumns($model_name);
            foreach ($data as $key => $value) {
                $this->$key = $value;
            }
            return $this;
        } else {
            return false;
        }
    }
}