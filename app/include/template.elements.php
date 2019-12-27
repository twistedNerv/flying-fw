<?php

class templateElements extends template {
    
    public function __construct() {
        $this->config = new config;
        $this->filesFolder = 'app/views/' . $this->config->getParam('template'). '/template/elements/';
    }
    
    public function submitButton($nameid="", $buttontype="primary", $text="Potrdi", $class="") {
        $fileContent = $this->getFileContent('submit_button');
        $ref = new ReflectionMethod($this, 'submitButton');
        foreach($ref->getParameters() as $param) {
                $name = $param->name;
                $params[$name] = $$name;
        }
        $fileContent = $this->replaceTags($params, $fileContent);
        echo $fileContent;
    }
    
    public function formInputText($type, $nameid, $value, $placeholder="", $required="") {
        $fileContent = $this->getFileContent('form_input_text');
        $ref = new ReflectionMethod($this, 'formInputText');
        foreach($ref->getParameters() as $param) {
            $name = $param->name;
            $params[$name] = $$name;
        }
        echo $this->replaceTags($params, $fileContent);
    }
    
    private function replaceTags($params, $fileContent) {
        foreach ($params as $param => $value) {
            $tag = '[['.$param.']]';
            $fileContent = str_replace($tag, $value, $fileContent);
        }
        return $fileContent;
    }
    
    public function getFileContent($filename) {
        $file = $this->filesFolder . $filename . '.tmpl';
        if(file_exists($file)) {
            $content = file_get_contents($file);
            return $content;
        } else {
            echo "File does not exist.";
        }
    }
 }
