<?php
require_once 'app/include/template.elements.php';
require_once 'app/include/template.tools.php';

class template {
    
    public $elements;
    public $tools;
    
    public function __construct() {
        $this->elements = new templateElements;
        $this->tools = new templateTools();
    }
}
