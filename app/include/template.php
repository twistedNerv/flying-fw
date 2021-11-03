<?php

class template {
    
    public function __construct() {
        //
    }
    
    public function setUpdateTextValue($value) {
        $value = (isset($value) && $value) ? $value : "";
        return  'value="' . $value . '"';
    }
    
    public function setUpdateTextareaValue($value) {
        $value = (isset($value) && $value) ? $value : "";
        return  $value;
    }
    
    public function setUpdateSelectValue($value, $condition1, $condition2="") {
        $condition2 = ($condition2) ? $condition2 : $value;
        $selected = ($condition1 == $condition2) ? "selected" : "";
        return 'value="' . $value . '" ' . $selected;
    }
    
    public function setUpdateSelectOption($value, $condition1, $condition2="") {
        $condition2 = ($condition2) ? $condition2 : $value;
        $selected = ($condition1 == $condition2) ? "selected" : "";
        //echo '<option value="' . $value . '" ' . $selected . '>' . $value . '</option>';
        return '<option value="' . $value . '" ' . $selected . '>' . $value . '</option>';
    }
    
    public function getImage($file) {
        return  URL . "public/" . TEMPLATE . "/images/" . $file;
    }
    
    public function progressBar($percent, $title, $bar_color, $bg_color, $status_index=0) {
        if ($percent >= 100 && $status_index != 4) {
            $bar_color = "#a02c2d";
            $title = "Prekoračen rok";
        }
        if ($percent == 0) {
            $bar_color = $bg_color = "#dddddd";
        }
        if ($status_index == 4) {
            $bar_color = $bg_color = "transparent";
        }
        $bar = "<div class='progress-bar-outer' style='background-color:" . $bg_color . ";' title='" . $title . "'>";
        $bar .= "<div class='progress-bar-inner' style='width:" . $percent . "%;background-color:" . $bar_color . ";'></div>";
        $bar .= "</div>";
        return $bar;
    }
    
    public function readableColour($bg) {
        $bg = str_replace("#", "", $bg);
        list($r, $g, $b) = sscanf($bg, "%02x%02x%02x");
        $squared_contrast = (
                $r * $r * .299 +
                $g * $g * .587 +
                $b * $b * .114 );
        return ($squared_contrast > pow(130, 2)) ? '333333' : 'dddddd';
    }
    
    public function uploadedFilePath($file) {
        return URL . 'uploads/' . $file;
    }
    
    public function getImagePath($file) {
        $this->config = new config;
        return URL . 'public/' . $this->config->getParam('template') . '/images/' . $file;
    }
    
    public function getFileIcon($file) {
        $fileParse = explode('.', $file);
        $extension = end($fileParse);
        switch($extension) {
            case 'jpg':
            case 'jpeg':
            case 'gif':
            case 'png':
                return "fa fa-file-image";
            case 'pdf':
                return "fa fa-file-pdf";
            case 'doc':
            case 'docs':
                return "fa fa-file-word";
            case 'xls':
            case 'xlsx':
                return "fa fa-file-excel-o";
            case 'txt':
                return "fa fa-file-text-o";
            case 'csv':
                return "fa fa-file-csv";
            case 'zip':
            case 'arj':
            case 'rar':
                return "fa fa-file-archive-o";
            default:
                return "fa fa-file";
        }
    }
    
}
