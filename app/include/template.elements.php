<?php

class templateElements extends template {
    
    public function __construct() {
        $this->config = new config;
        $this->filesFolder = 'app/views/' . $this->config->getParam('template'). '/template/elements/';
    }
    
    public function submitButton($nameid="", $buttontype="primary", $text="Potrdi", $class="") {
        $fileContent = parent::getFileContent('submit_button', $this->filesFolder);
        $ref = new ReflectionMethod($this, 'submitButton');
        foreach($ref->getParameters() as $param) {
                $name = $param->name;
                $params[$name] = $$name;
        }
        echo parent::replaceTags($params, $fileContent);
    }
    
    public function formInputText($type, $nameid, $value, $placeholder="", $required="") {
        $fileContent = parent::getFileContent('form_input_text', $this->filesFolder);
        $ref = new ReflectionMethod($this, 'formInputText');
        foreach($ref->getParameters() as $param) {
            $name = $param->name;
            $params[$name] = $$name;
        }
        echo parent::replaceTags($params, $fileContent);
    }
    
    
 }
