<?php

class logsModel extends model {

    public $id;
    public $type;
    public $log;
    public $datetime;
    public $userid;
    public $userip;
    public $useragent;

    public function __construct() {
        parent::__construct();
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function getLog() {
        return $this->log;
    }

    public function setLog($log) {
        $this->log = $log;
        return $this;
    }

    public function getDatetime() {
        return $this->datetime;
    }

    public function setDatetime($datetime) {
        $this->datetime = $datetime;
        return $this;
    }

    public function getUserid() {
        return $this->userid;
    }

    public function setUserid($userid) {
        $this->userid = $userid;
        return $this;
    }

    public function getUserip() {
        return $this->userip;
    }

    public function setUserip($userip) {
        $this->userip = $userip;
        return $this;
    }

    public function getUseragent() {
        return $this->useragent;
    }

    public function setUseragent($useragent) {
        $this->useragent = $useragent;
        return $this;
    }

    public function getOneBy($ident, $value) {
        $result = $this->db->getOneByParam($ident, $value, 'logs');
        $this->fillLogs($result);
        return $this;
    }

    public function getAll($orderBy = null, $order = null, $limit = null) {
        return $this->db->getAll($orderBy, $order, $limit, 'logs');
    }
    
    public function getAllBy($ident, $identVal, $orderBy = null, $orderDirection = 'ASC', $limit=null) {
        return $this->db->getAllByParam($ident, $identVal, 'logs', $orderBy, $orderDirection, $limit);
    }

    public function flush($sqlDump = 0) {
        $this->db->flush($this, 'logs', $sqlDump);
    }

    public function remove() {
        $this->db->delete($this, 'logs');
    }

    public function fillLogs($data) {
        $columns = $this->db->getTableColumns('logs');
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
        return $this;
    }

    public function getAllLogsByParams($condition = [], $order = [], $limit = []) {
        $sql = "SELECT 
                l.id as lid,
                l.type as type,
                l.log as log,
                l.datetime as logdatetime,
                l.useragent as agent,
                l.userip as ip,
                l.userid as userid,
                u.name as user_name,
                u.surname as user_surname
                FROM logs AS l
                LEFT JOIN user as u 
                ON l.userid = u.id
                WHERE 1 = 1 ";
        if (isset($condition['search']) && $condition['search'] && $condition['search'] != "") {
            $sql .= "AND (l.log LIKE :search) ";
            $condition['search'] = "%" . $condition['search'] . "%";
        }
        if (isset($condition['type']) && $condition['type'] && $condition['type'] != "") {
            $sql .= "AND (l.type LIKE :type) ";
        }
        if (isset($condition['user']) && $condition['user'] && $condition['user'] != "") {
            $sql .= "AND (l.userid LIKE :userid) ";
        }
        if (isset($condition['datetime-from']) && $condition['datetime-from'] && $condition['datetime-from'] != 0) {
            $sql .= "AND CONCAT(SUBSTR(l.datetime, 7, 4), SUBSTR(l.datetime, 4, 2), SUBSTR(l.datetime, 1, 2)) >= CONCAT(SUBSTR(:datetime_from, 7, 4), SUBSTR(:datetime_from, 4, 2), SUBSTR(:datetime_from, 1, 2)) ";
        }
        if (isset($condition['datetime-to']) && $condition['datetime-to'] && $condition['datetime-to'] != 0) {
            $sql .= "AND CONCAT(SUBSTR(datetime_to, 7, 4), SUBSTR(datetime_to, 4, 2), SUBSTR(datetime_to, 1, 2)) <= CONCAT(SUBSTR(:datetime_to, 7, 4), SUBSTR(:datetime_to, 4, 2), SUBSTR(:datetime_to, 1, 2)) ";
        }
        if (isset($order['order_by']) && $order['order_by']) {
            $sql .= "ORDER BY " . $order['order_by'] . " ";
        } else {
            $sql .= "ORDER BY lid ";
        }
        if (isset($order['order_direction']) && $order['order_direction']) {
            $sql .= $order['order_direction'] . " ";
        } else {
            $sql .="DESC ";
        }
        if (isset($limit['limit']) && $limit['limit']) {
            $sql .= "LIMIT " . $limit['limit'] . ";";
        } else {
            $sql .= "LIMIT 25;";
        }
        $result = $this->db->prepare($sql);
        if (isset($condition['search']) && $condition['search'] && $condition['search'] != "") {
            $result->bindParam(':search', $condition['search']);
        }
        if (isset($condition['type']) && $condition['type'] && $condition['type'] != "") {
            $result->bindParam(':type', $condition['type']);
        }
        if (isset($condition['user']) && $condition['user'] && $condition['user'] != "") {
            $result->bindParam(':userid', $condition['user']);
        }
        if (isset($condition['datetime-from']) && $condition['datetime-from']) {
            $result->bindParam(':datetime_from', $condition['datetime-from']);
        }
        if (isset($condition['datetime-to']) && $condition['datetime-to']) {
            $result->bindParam(':datetime_to', $condition['datetime-to']);
        }
        $result->execute();
        //echo "<pre>";$result->debugDumpParams();echo "</pre>";//die;
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    public function getAllTypes() {
        $sql = "SELECT type FROM logs GROUP BY type ORDER BY type";
        $result = $this->db->prepare($sql);
        $result->execute();
        //echo "<pre>";$result->debugDumpParams();echo "</pre>";//die;
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    
    public function getAllLoggedUsers() {
        $sql = "SELECT u.id as uid, u.name as uname, surname as usurname, l.userid as lid FROM user as u INNER JOIN logs as l ON u.id = l.userid GROUP BY lid ORDER BY uname";
        $result = $this->db->prepare($sql);
        $result->execute();
        //echo "<pre>";$result->debugDumpParams();echo "</pre>";//die;
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
}
