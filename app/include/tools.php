<?php

class tools {

    public function __construct() {
        $this->session = new session;
    }

    public function checkPageRights($level) {
        $userLevel = $this->session->get('activeUser');
        //echo $userLevel['level'];die;
        if ($level != 0) {
            if (!$userLevel['level'] || $userLevel['level'] < $level) {
                $redirectLocation = URL . "user/login";
                //$redirectLocation = "location: ".URL."user/login";
                //header($redirectLocation);
                $this->redirect($redirectLocation);
            }
        }
    }

    public function sanitizePost($postData) {
        $result = (isset($postData) && $postData != "") ? filter_var($postData, FILTER_SANITIZE_STRING) : "";
        return $result;
    }

    /*
     * nText - text to be displayed
     * nType - type of notification. Posibilities: primary, success, alert, warning, info
     */

    public function notification($nText, $nType = 'primary') {
        $notificationDisplay = "<div class='notification-wrapper' id='notification-wrapper'>";
        $notificationDisplay .= "<div class='notification-frame'>";
        $notificationDisplay .= "<div class='notification-text'>";
        $notificationDisplay .= $nText;
        $notificationDisplay .= "</div>";
        $notificationDisplay .= "<button class='notification-button btn btn-$nType'>OK</button>";
        $notificationDisplay .= "</div>";
        $notificationDisplay .= "</div>";
        echo $notificationDisplay;
    }

    public function log($logtype, $log) {
        $link = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $dtNow = date("d.m.Y H:i:s");
        $userIdParam = (isset(session::get('activeUser')['id'])) ? session::get('activeUser')['id'] : "N/A";
        $insertLog = $link->prepare('INSERT INTO logs (type, log, datetime, userid, userip, useragent) '
                . 'VALUES (:type, :log, :datetime, :userid, :userip, :useragent)');
        $insertLog->bindParam(':type', $logtype);
        $insertLog->bindParam(':log', $log);
        $insertLog->bindParam(':datetime', $dtNow);
        $insertLog->bindParam(':userid', $userIdParam);
        $insertLog->bindParam(':userip', $_SERVER['REMOTE_ADDR']);
        $insertLog->bindParam(':useragent', $_SERVER['HTTP_USER_AGENT']);
        $insertLog->execute();
    }

    public function redirect($url) {
        if ($url) {
            die("<script>location.href = '" . $url . "'</script>");
        }
    }

    public function getClassLineage($object){
        $class_name = get_class($object);
        $parents = array_values(class_parents($class_name));
        return array_merge(array($class_name), $parents);
    }
}
