<?php

class templateElements extends template {
    
    public function __construct() {
        $this->config = new config;
        $this->filesFolder = 'app/views/' . $this->config->getParam('template'). '/template/elements/';
    }
    
    public function formInputText($type, $nameid, $value, $placeholder="", $required="") {
        
        $fileContent = $this->getFileContent($this->filesFolder . 'form_input_text.tmpl');
        $ref = new ReflectionMethod($this, 'formInputText');
        foreach($ref->getParameters() as $param) {
            $name = $param->name;
            $params[$name] = $$name;
        }
        $fileContent = $this->replaceTags($params, $fileContent);
        echo $fileContent;
    }
    
    private function replaceTags($params, $fileContent) {
        foreach ($params as $param => $value) {
            $tag = '[['.$param.']]';
            $fileContent = str_replace($tag, $value, $fileContent);
        }
        return $fileContent;
    }
    
    public function getFileContent($file) {
        if(file_exists($file)) {
            $content = file_get_contents($file);
            return $content;
        } else {
            echo "File does not exist.";
        }
    }
 }
