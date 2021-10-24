<!doctype html>
<html>
    <head>
        <title><?=$this->config->getParam('title')?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <?php $this->config->includeJquery();?>
        <?php $this->config->includeBootstrap();?>
        <?php $this->config->includeFontawesomeCustom();?>
        <?php $this->config->includeEasyeditor();?>
        <?php //$this->config->includeStyle('jquery-ui.css');?>
        <?php $this->config->includeStyle('fonts/fonts.css');?>
        <?php $this->config->includeStyle('default.css');?>
        <?php $this->config->includeScript('default.js');?>
        <script>var URL = "<?=URL?>";</script>
        <?php $this->config->includeScript('ajax.js');?>
        <link href="<?=URL?>public/<?=TEMPLATE?>/images/favicon.ico" rel="shortcut icon" type="image/x-icon" />
        <script>
            $(function() {
                $(".pick-a-date").datepicker({
                    showAnim: "slideDown",
                    dateFormat: "dd.mm.yy",
                    firstDay: 1
                });
            });
        </script>
    </head>
    <body>
        <div class="col-sm-2"></div>
        <div class="container col-sm-8">
            <div class="col-sm-12 header no-print">
                <div class="header-content">
                    <div class="col-sm-4 float-left">
                        <img src='<?= URL ?>public/<?= TEMPLATE ?>/images/logo.png' class="header-logo">
                    </div>
                    <div class="col-sm-8 header-right">
                        <span class="float-left"><h1 class="header-title"><?=$this->config->getParam('header_title')?></h1></span>
                        <span class="float-right"><img src="<?= URL ?>public/<?= TEMPLATE ?>/images/img-right.png"></span>
                    </div>
                </div>
            </div>
            <?php 
            if($this->config->getParam('display_page_header')) {
                require 'menu.php';
            }
            ?>
            <div id="content" class="content row">
                