<?php
require_once 'app/include/template.elements.php';
require_once 'app/include/template.tools.php';

class template {
    
    public $elements;
    public $tools;
    public $vars = [];
    
    public function __construct() {
        $this->elements = new templateElements;
        $this->tools = new templateTools;
        $this->config = new config;
    }
    
    public function assign($key, $value) {
        $this->vars[$key] = $value;
    }
    
    public function prepare($template, $clearVars=0, $isRootTemplate=0) {
        $contentFolder = (!$isRootTemplate) ? "content/" : "";
        $contentFolder = 'app/' . $contentFolder . 'views/' . $this->config->getParam('template'). '/template/';
        $fileContent = $this->getFileContent($template, $contentFolder);
        $params = $this->vars;
        if ($clearVars) $this->vars = [];
        return $this->replaceTags($this->vars, $fileContent);
    }
    
    public function replaceTags($params, $fileContent, $startTag='[[', $endTag=']]') {
        foreach ($params as $param => $value) {
            $tag = $startTag . $param . $endTag;
            $fileContent = str_replace($tag, $value, $fileContent);
        }
        return $fileContent;
    }
    
    public function getFileContent($filename, $filesFolder) {
        $file = $filesFolder . $filename . '.tmpl';
        if(file_exists($file)) {
            $content = file_get_contents($file);
            return $content;
        } else {
            echo "File does not exist.";
        }
    }
}
