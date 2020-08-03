<?php

class menuModel extends model {

    public $id;
    public $title;
    public $description;
    public $url;
    public $level;
    public $position;
    public $parent;
    public $active;
    public $admin;

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
        $result = $this->db->findOneByParam('id', $value, 'menu');
        $this->fillMenu($result);
        return $this;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function findOneByTitle($value) {
        $result = $this->db->findOneByParam('title', $value, 'menu');
        $this->fillMenu($result);
        return $this;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function findOneByDescription($value) {
        $result = $this->db->findOneByParam('description', $value, 'menu');
        $this->fillMenu($result);
        return $this;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
        return $this;
    }

    public function findOneByUrl($value) {
        $result = $this->db->findOneByParam('url', $value, 'menu');
        $this->fillMenu($result);
        return $this;
    }

    public function getLevel() {
        return $this->level;
    }

    public function setLevel($level) {
        $this->level = $level;
        return $this;
    }

    public function findOneByLevel($value) {
        $result = $this->db->findOneByParam('level', $value, 'menu');
        $this->fillMenu($result);
        return $this;
    }

    public function getPosition() {
        return $this->position;
    }

    public function setPosition($position) {
        $this->position = $position;
        return $this;
    }

    public function findOneByPosition($value) {
        $result = $this->db->findOneByParam('position', $value, 'menu');
        $this->fillMenu($result);
        return $this;
    }

    public function getParent() {
        return $this->parent;
    }

    public function setParent($parent) {
        $this->parent = $parent;
        return $this;
    }

    public function findOneByParent($value) {
        $result = $this->db->findOneByParam('parent', $value, 'menu');
        $this->fillMenu($result);
        return $this;
    }

    public function getActive() {
        return $this->active;
    }

    public function setActive($active) {
        $this->active = $active;
        return $this;
    }

    public function findOneByActive($value) {
        $result = $this->db->findOneByParam('active', $value, 'menu');
        $this->fillMenu($result);
        return $this;
    }

    public function getAdmin() {
        return $this->admin;
    }

    public function setAdmin($admin) {
        $this->admin = $admin;
        return $this;
    }

    public function findOneByAdmin($value) {
        $result = $this->db->findOneByParam('admin', $value, 'menu');
        $this->fillMenu($result);
        return $this;
    }

    public function findAll() {
        return $this->db->findAll('menu');
    }

    public function flush() {
        $this->db->flush($this, 'menu');
    }

    public function remove() {
        $this->db->delete($this, 'menu');
    }

    public function fillMenu($data) {
        $columns = $this->db->getTableColumns('menu');
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
        return $this;
    }
    
    public function findAllByParent($parent) {
        return $this->db->findAllByParam('parent', $parent, 'menu');
    }

    public function findMenuItems($admin = false, $active = true, $parent = '0') {
        $adminCondition = ($admin) ? "AND menu.admin = 1" : "AND menu.admin = 0";
        $activeCondition = ($active) ? "AND menu.active = 1" : "";
        $parentCondition = ($parent == 'all') ? "" : "AND menu.parent = " . $parent;
        $this->db->result = $this->db->prepare("
                                SELECT menu.id as id, 
                                        menu.title as title, 
                                        menu.description as description, 
                                        menu.url as url, 
                                        menu.level as level, 
                                        menu.position as position, 
                                        menu.parent as parent, 
                                        menu.active as active, 
                                        menu.admin as admin,
                                        parent.title as parenttitle
                                        FROM menu as menu
                                        LEFT JOIN menu AS parent ON menu.parent = parent.id
                                        WHERE 1=1 " . $adminCondition . " " . $activeCondition . " " . $parentCondition . "
                                        ORDER BY parent ASC, position;");
        $this->db->result->execute();
        return $this->db->result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findNextItem($direction, $admin, $parent, $currentPosition) {
        if ($direction == "up") {
            $direction = "<"; 
            $way = "DESC";
        } else {
            $direction = ">";
            $way = "ASC";
        }
        $sql = "SELECT * FROM menu 
            WHERE active = 1 AND admin = " . $admin . " AND parent = " . $parent . " AND position " . $direction . " " . $currentPosition . "
            ORDER BY position " . $way . " LIMIT 1;";
        return $this->db->selectResult($sql);
    }
    
    public function getNextPosition($admin, $parent) {
        $parent = (!$parent) ? "0" : $parent;
        $sql = "SELECT position FROM menu WHERE active = 1 AND admin = " . $admin . " AND parent = " . $parent . " ORDER BY position DESC LIMIT 1";
        return $this->db->selectResult($sql);
    }
}
