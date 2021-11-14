<?php

class model {

    public function __construct() {
        $this->db = new db();
        $this->tools = new tools;
    }

}