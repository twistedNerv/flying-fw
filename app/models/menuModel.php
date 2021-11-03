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

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
        return $this;
    }

    public function getLevel() {
        return $this->level;
    }

    public function setLevel($level) {
        $this->level = $level;
        return $this;
    }

    public function getPosition() {
        return $this->position;
    }

    public function setPosition($position) {
        $this->position = $position;
        return $this;
    }

    public function getParent() {
        return $this->parent;
    }

    public function setParent($parent) {
        $this->parent = $parent;
        return $this;
    }

    public function getActive() {
        return $this->active;
    }

    public function setActive($active) {
        $this->active = $active;
        return $this;
    }

    public function getAdmin() {
        return $this->admin;
    }

    public function setAdmin($admin) {
        $this->admin = $admin;
        return $this;
    }

    public function getOneBy($ident, $value) {
        $result = $this->db->getOneByParam($ident, $value, 'menu');
        $this->fillMenu($result);
        return $this;
    }

    public function getAll($orderBy = null, $order = null, $limit = null) {
        return $this->db->getAll($orderBy, $order, $limit, 'menu');
    }
    
    public function getAllBy($ident, $identVal, $orderBy = null, $orderDirection = 'ASC', $limit=null) {
        return $this->db->getAllByParam($ident, $identVal, 'menu', $orderBy, $orderDirection, $limit);
    }

    public function flush($sqlDump = 0) {
        $this->db->flush($this, 'menu', $sqlDump);
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

    public function getAllByParent($parent) {
        return $this->db->getAllByParam('parent', $parent, 'menu');
    }

    public function getMenuItems($admin = false, $active = true, $parent = '0') {
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
        //echo "<pre>";$this->db->result->debugDumpParams();die;
        $menuItems = $this->db->result->fetchAll(PDO::FETCH_ASSOC);
        $session = new session();
        if ($session->get('activeUser') && $session->get('activeUser')['level'] < 5 && $admin == false) {
            $membershipModel = new membershipModel;
            $actiongroupModel = new actiongroupModel;
            $allActionGroups = $actiongroupModel->getAll();
            foreach ($menuItems as $key => $singleItem) {
                if ($this->in_array_r($singleItem['url'], $allActionGroups)) {
                    $userMember = $membershipModel->getOneByUserAndGroup($session->get('activeUser')['id'], $actiongroupModel->getOneByAction($singleItem['url'])->id);
                    if (!$userMember) {
                        unset($menuItems[$key]);
                    }
                }
            }
        }
        return $menuItems;
    }

    public function getNextItem($direction, $admin, $parent, $currentPosition) {
        if ($direction == "up") {
            $direction = "<";
            $way = "DESC";
        } else {
            $direction = ">";
            $way = "ASC";
        }
        $sql = "SELECT * FROM menu 
            WHERE active = 1 AND admin = :admin AND parent = :parent AND position " . $direction . " " . $currentPosition . "
            ORDER BY position " . $way . " LIMIT 1;";
        $this->db->result = $this->db->prepare($sql);
        $this->db->result->bindParam(':admin', $admin);
        $this->db->result->bindParam(':parent', $parent);
        $this->db->result->execute();
        return $this->db->result->fetch(PDO::FETCH_ASSOC);
    }

    public function getNextPosition($admin, $parent) {
        $parent = (!$parent) ? "0" : $parent;
        $sql = "SELECT position FROM menu WHERE active = 1 AND admin = " . $admin . " AND parent = " . $parent . " ORDER BY position DESC LIMIT 1";
        $this->db->result = $this->db->prepare($sql);
        $this->db->result->bindParam(':admin', $admin);
        $this->db->result->bindParam(':parent', $parent);
        $this->db->result->execute();
        return $this->db->result->fetch(PDO::FETCH_ASSOC);
    }

    private function in_array_r($needle, $haystack, $strict = false) {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->in_array_r($needle, $item, $strict))) {
                return true;
            }
        }
        return false;
    }

}
