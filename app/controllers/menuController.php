<?php

class menuController extends controller {

    public function __construct() {
        parent::__construct();
    }
    
    public function updateAction($menuId=0) {
        $menuModel = $this->loadModel('menu');
        if($menuId != 0) {
            $menuModel->findOneById($menuId);
        }
        if(isset($_POST['action']) && $_POST['action'] == 'handlemenu') {
            $menuModel->setName(tools::sanitizePost($_POST['menu-title']));
            $menuModel->setName(tools::sanitizePost($_POST['menu-description']));
            $menuModel->setName(tools::sanitizePost($_POST['menu-url']));
            $menuModel->setName(tools::sanitizePost($_POST['menu-level']));
            $menuModel->setName(tools::sanitizePost($_POST['menu-position']));
            $menuModel->setName(tools::sanitizePost($_POST['menu-parent']));
            $menuModel->setName(tools::sanitizePost($_POST['menu-active']));
            $menuModel->setName(tools::sanitizePost($_POST['menu-admin']));
            $menuModel->flush();
            $this->tools->notification("Menu element urejen.", "primary");
            $this->tools->log('menu', "Menu item: " . $menuModel->getTitle() . " successfully added.");
        }
        $allMenuItems = $menuModel->findMenuItems(false, true, 'all');
        $allAdminMenuItems = $menuModel->findMenuItems(true, true, 'all');
        $parentGroups = $menuModel->findMenuItems(false, true, '0');
        $customMenuArray = [];
            foreach($allMenuItems as $singleItem) {
                $index = ($singleItem['parent'] != 0) ? $singleItem['parenttitle'] : 0;
                $customMenuArray[$index][] =  ['id' => $singleItem['id'], 'title' => $singleItem['title'], 'url' => $singleItem['url'], 'parenttitle' => $singleItem['parenttitle']];
            }
        $this->view->render('menu/update', ['pageMenuItems' => $customMenuArray, 'adminMenuItems' => $allAdminMenuItems, 'parentGroups' => $parentGroups]);
    }

    public function indexAction() {
        if (isset($_POST['action']) && $_POST['action'] == 'addmenuitem') {
            $newMenuItem = $this->loadModel('menu');
            $newMenuItem->title = $_POST['menu-title'];
            $newMenuItem->description = $_POST['menu-description'];
            $newMenuItem->url = $_POST['menu-url'];
            $newMenuItem->level = (isset($_POST['menu-level']) && $_POST['menu-level']) ? $_POST['menu-level'] : "1";
            $newMenuItem->position = (isset($_POST['menu-position']) && $_POST['menu-position']) ? $_POST['menu-position'] : "1";
            $newMenuItem->parent = (isset($_POST['menu-parent']) && $_POST['menu-parent']) ? $_POST['menu-parent'] : "0";
            $newMenuItem->active = $_POST['menu-active'];
            $newMenuItem->admin = $_POST['menu-admin'];
            $newMenuItem->flush();
            $this->tools->notification("Dodan element v menu.", "primary");
            $this->tools->log('menu', "New menu element $newMenuItem->title added");
        }
        $menuModel = $this->loadModel("menu");
        $allPageMenuItems = $menuModel->findMenuItems(false, true, '0');
        $allAdminMenuItems = $menuModel->findMenuItems(true, true, 'all');
        $parentGroups = $menuModel->findMenuItems(false, true, '0');
        
        $this->view->render('menu/index', ['pageMenuItems' => $allPageMenuItems, 'adminMenuItems' => $allAdminMenuItems, 'parentGroups' => $parentGroups]);
    }
    
    public function removeAction($menuItemId) {
        if ($menuItemId) {
            $menuModel = $this->loadModel('menu');
            $menuModel->findOneById($menuItemId);
            $menuModel->remove();
            $this->tools->log('menu', "Menu item with id: $menuItemId removed.");
            $this->tools->redirect(URL . 'menu/update');
        } else {
            echo "No menu item id selected!";
        }
    }
}
