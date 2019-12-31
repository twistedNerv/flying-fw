<!doctype html>
<html>
    <head>
        <title><?=$this->config->getParam('title')?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <?php $this->config->includeScript('jquery.js');?>
        <?php $this->config->includeScript('jquery-ui.js');?>
        <?php $this->config->includeBootstrap();?>
        <?php $this->config->includeStyle('default.css');?>
        <?php $this->config->includeStyle('notification.css');?>
        <?php $this->config->includeStyle('jquery-ui.css');?>
        <?php $this->config->includeScript('default.js');?>
        <?php $this->config->includeScript('notification.js');?>
        <?php $this->config->includeScript('ajax.js');?>
        <link href="<?=URL?>public/default/images/faviconukc.ico" rel="shortcut icon" type="image/x-icon" />
    </head>
    <body>
        <div class="container">
            <?php 
            if($this->config->getParam('display_page_menu')) {
                require 'menu.php';
            }
            ?>
            
            <div id="content" class="content row">
                