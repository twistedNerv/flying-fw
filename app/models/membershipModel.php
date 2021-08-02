<?php

class membershipModel extends model {

    public $id;
    public $user_id;
    public $actiongroup_id;

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

    public function findOneById($value) {
        $result = $this->db->findOneByParam('id', $value, 'membership');
        $this->fillMembership($result);
        return $this;
    }

    public function getUser_id() {
        return $this->user_id;
    }

    public function setUser_id($user_id) {
        $this->user_id = $user_id;
        return $this;
    }

    public function findOneByUser_id($value) {
        $result = $this->db->findOneByParam('user_id', $value, 'membership');
        $this->fillMembership($result);
        return $this;
    }

    public function getActiongroup_id() {
        return $this->actiongroup_id;
    }

    public function setActiongroup_id($actiongroup_id) {
        $this->actiongroup_id = $actiongroup_id;
        return $this;
    }

    public function findOneByActiongroup_id($value) {
        $result = $this->db->findOneByParam('actiongroup_id', $value, 'membership');
        $this->fillMembership($result);
        return $this;
    }

    public function findAll() {
        return $this->db->findAll('membership');
    }

    public function flush($sqlDump = 0) {
        $this->db->flush($this, 'membership', $sqlDump);
    }

    public function remove() {
        $this->db->delete($this, 'membership');
    }

    public function fillMembership($data) {
        $columns = $this->db->getTableColumns('membership');
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
        return $this;
    }

    public function findAllBy($ident, $identVal, $orderBy = null, $orderDirection = 'ASC') {
        return $this->db->findAllByParam($ident, $identVal, 'membership', $orderBy, $orderDirection);
    }
    
    public function findOneByUserAndGroup($userId, $actiongroupId) {
        $checkSql = "SELECT id FROM membership WHERE user_id = " . $userId . " AND actiongroup_id = " . $actiongroupId;
        return $this->db->selectResult($checkSql);
    }

    public function findAllUsersMemberships($userId) {
        $this->db->result = $this->db->prepare("
            SELECT m.id as mid, ag.name as name, ag.action as action, ag.section as section
            FROM membership as m 
            INNER JOIN actiongroup as ag 
            ON m.actiongroup_id = ag.id 
            WHERE m.user_id = :user_id");
        $this->db->result->bindParam(':user_id', $userId);
        $this->db->result->execute();
        return $this->db->result->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function findAllActiongroupUsers($actiongroupId) {
        $this->db->result = $this->db->prepare("
            SELECT u.id as id, u.name as name, u.surname as surname
            FROM membership as m 
            INNER JOIN user as u 
            ON m.user_id = u.id 
            WHERE m.actiongroup_id = :actiongroup_id");
        $this->db->result->bindParam(':actiongroup_id', $actiongroupId);
        $this->db->result->execute();
        return $this->db->result->fetchAll(PDO::FETCH_ASSOC);
    }
}
