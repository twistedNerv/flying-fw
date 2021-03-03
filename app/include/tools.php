<?php

class tools {

    public function __construct() {
        require_once 'app/core/session.php';
        $this->session = new session;
    }

    public function checkPageRights($level) {
        $userLevel = $this->session->get('activeUser')['level'];
        if ($level != 0) {
            if (!$userLevel || $userLevel < $level) {
                $redirectLocation = URL . "user/login";
                $this->redirect($redirectLocation);
            }
        }
    }

    public function checkUserMembershipActiongroup() {
        if ($this->session->get('activeUser')['level'] == 5) 
            return true;
        
        $classMethod = $this->getUrlClassMethod();
        require_once 'app/models/actiongroupModel.php';
        require_once 'app/models/membershipModel.php';
        $actiongroupModel = new actiongroupModel();
        $actiongroup = $actiongroupModel->findOneByAction($classMethod);
        if ($actiongroup->id) {
            $membershipModel = new membershipModel();
            $isMember = $membershipModel->findOneByUserAndGroup($this->session->get('activeUser')['id'], $actiongroup->id);
            if (!$isMember) {
                return false;
            }
        }
        return true;
    }
    
    public function getUrlClassMethod() {
        $url = $this->parseUrl();
        $class = (isset($url[0]) && $url[0] != '') ? $url[0] : 'home';
        $method = (isset($url[1]) && $url[1] != '') ? $url[1] : 'index';
        return $class . '/' . $method;
    }
    
    public function parseUrl() {
        if(isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return false;
    }
    

    public function sanitizePost($postData) {
        $result = (isset($postData) && $postData != "") ? filter_var($postData, FILTER_SANITIZE_STRING) : "";
        return $result;
    }
    
    public function getPost($post_name) {
        $result = (isset($_POST[$post_name]) && $_POST[$post_name] != "") ? filter_var($_POST[$post_name], FILTER_SANITIZE_STRING) : "";
        return $result;
    }

    public function genericPostToObj($object, $class, $postData) {
        foreach ($postData as $key => $value) {
            if ($key != "action") {
                $setMethod = "set" . ucfirst(str_replace($class . "-", "", $this->sanitizePost($key)));
                $object->$setMethod($value);
            }
        }
        return $object;
    }

    /*
     * nText - text to be displayed
     * nType - type of notification. Posibilities: primary, success, alert, warning, info
     */

    public function notification($nText, $nType = 'primary') {
        $notificationDisplay = "<div class='notification-wrapper' id='notification-wrapper' style='display:none;'>";
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
        $userIdParam = (isset($this->session->get('activeUser')['id'])) ? $this->session->get('activeUser')['id'] : "N/A";
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

    public function getClassLineage($object) {
        $class_name = get_class($object);
        $parents = array_values(class_parents($class_name));
        return array_merge(array($class_name), $parents);
    }

    public function progressPercent($from, $to, $now = 'now') {
        date_default_timezone_set('Europe/Ljubljana');
        $from = date_create(str_replace(".", "-", $from));
        $to = date_create(str_replace(".", "-", $to));
        if ($now != 'now') {
            $now = str_replace(".", "-", $now);
            $now = date_create($now);
        } else {
            $now = new DateTime();
        }
        if ($now < $from) {
            return 0;
        }
        $tillEnd = $this->daysBetween($from, $to);
        $tillNow = $this->daysBetween($from, $now);
        $result = round($tillNow / $tillEnd * 100);
        return ($result < 100) ? $result : 100;
    }

    public function daysBetween($from, $to) {
        $datediff = date_diff($to, $from);
        return abs($datediff->format("%a"));
    }

    public function refactorDate($date) {
        $dateArr = explode(".", $date);
        $month = ltrim($dateArr[1], "0");
        //$month -= 1;
        $result = $dateArr[2] . "-" . $month . "-" . ltrim($dateArr[0], "0");
        return $result . " 00:00";
    }

    public function isTooLate($date) {
        $dateArr = explode(".", $date);
        $mDate = $dateArr[2] . $dateArr[1] . $dateArr[0];
        if ($mDate < date("Ymd")) {
            return true;
        }
        return false;
    }

}
