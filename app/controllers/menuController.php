<?php

class menuController extends controller {

    public function __construct() {
        parent::__construct();
        $this->tools->checkPageRights(4);
    }
    
    public function indexAction() {
        $menuModel = $this->loadModel("menu");
        if (isset($_POST['action']) && $_POST['action'] == 'addmenuitem') {
            $newMenuItem = $this->loadModel('menu');
            $newMenuItem->setTitle($this->tools->sanitizePost($_POST['menu-title']));
            $newMenuItem->setDescription($this->tools->sanitizePost($_POST['menu-description']));
            $newMenuItem->setUrl($this->tools->sanitizePost($_POST['menu-url']));
            $level = (isset($_POST['menu-level']) && $_POST['menu-level']) ? $this->tools->sanitizePost($_POST['menu-level']) : "1";
            $newMenuItem->setLevel($level);
            $parent = (isset($_POST['menu-parent'])) ? $_POST['menu-parent'] : "0";
            $position = $menuModel->getNextPosition($_POST['menu-admin'], $parent)['position'];
            $position++;
            $newMenuItem->setPosition($position);
            $newMenuItem->setParent($this->tools->sanitizePost($parent));
            $newMenuItem->setActive($this->tools->sanitizePost($_POST['menu-active']));
            $newMenuItem->setAdmin($this->tools->sanitizePost($_POST['menu-admin']));
            $newMenuItem->flush();
            $this->tools->notification("Dodan element v menu.", "primary");
            $this->tools->log('menu', "New menu element $newMenuItem->title added");
        }
        $allPageMenuItems = $menuModel->findMenuItems(false, true, 'all');
        $allAdminMenuItems = $menuModel->findMenuItems(true, true, 'all');
        $parentGroups = $menuModel->findMenuItems(false, true, '0');
        $this->view->assign('pageMenuItems', $allPageMenuItems);
        $this->view->assign('adminMenuItems', $allAdminMenuItems);
        $this->view->assign('parentGroups', $parentGroups);
        $this->view->render('menu/index');
    }
    
    public function removeAction($menuItemId) {
        if ($menuItemId) {
            $menuModel = $this->loadModel('menu');
            $menuModel->findOneById($menuItemId);
            $menuModel->remove();
            $childrenModel = $this->loadModel('menu');
            $children = $childrenModel->findAllByParent($menuItemId);
            foreach ($children as $singleChild) {
                $menuModel->findOneById($singleChild['id']);
                $menuModel->remove();
            }
            $this->tools->log('menu', "Menu item with id: $menuItemId and its potential subitems removed.");
            $this->tools->redirect(URL . 'menu');
        } else {
            echo "No menu item id selected!";
        }
    }
    
    public function moveAction($direction, $id) {
        $menuModel = $this->loadModel('menu');
        $menuItem = $menuModel->findOneById($id);
        $current_position = $menuItem->position;
        $nearItem = $menuModel->findNextItem($direction, $menuItem->admin, $menuItem->parent, $current_position);
        if ($nearItem['position'] > 0 && $menuItem->position > 0) {
            $menuItem->setPosition($nearItem['position']);
            $menuItem->flush();
            $swapItem = $menuModel->findOneById($nearItem['id']);
            $swapItem->setPosition($current_position);
            $swapItem->flush();
        }
        $this->tools->redirect(URL . 'menu');
    }
}
