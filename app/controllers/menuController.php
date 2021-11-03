<?php

class menuController extends controller {

    public function __construct() {
        parent::__construct();
        $this->tools->checkPageRights(4);
    }
    
    public function indexAction($menuId=false) {
        $newMenuItem = $this->loadModel('menu');
        if($menuId) {
            $newMenuItem->getOneBy('id', $menuId);
        }
        if ($this->tools->getPost('action')== 'addmenuitem') {
            $newMenuItem->setTitle($this->tools->getPost('menu-title'));
            $newMenuItem->setDescription($this->tools->getPost('menu-description'));
            $newMenuItem->setUrl($this->tools->getPost('menu-url'));
            $newMenuItem->setLevel($this->tools->getPost('menu-level'));
            if (!$menuId) {
                $position = $newMenuItem->getNextPosition($this->tools->getPost('menu-admin'), $this->tools->getPost('menu-parent'))['position'] + 1;
                $newMenuItem->setPosition($position);
            }
            $newMenuItem->setParent($this->tools->getPost('menu-parent'));
            $newMenuItem->setActive($this->tools->getPost('menu-active'));
            $newMenuItem->setAdmin($this->tools->getPost('menu-admin'));
            $newMenuItem->flush();
            $this->tools->log('menu', "New menu element $newMenuItem->title added");
        }
        $menuModel = $this->loadModel('menu');
        $allPageMenuItems = $menuModel->getMenuItems(false, false, 'all');
        $allAdminMenuItems = $menuModel->getMenuItems(true, false, 'all');
        $parentGroups = $menuModel->getMenuItems(false, false, '0');
        $this->view->assign('pageMenuItems', $allPageMenuItems);
        $this->view->assign('adminMenuItems', $allAdminMenuItems);
        $this->view->assign('parentGroups', $parentGroups);
        $this->view->assign('selectedItem', $newMenuItem);
        $this->view->render('menu/index');
    }
    
    public function removeAction($menuItemId) {
        if ($menuItemId) {
            $menuModel = $this->loadModel('menu');
            $menuModel->getOneBy('id', $menuItemId);
            $menuModel->remove();
            $childrenModel = $this->loadModel('menu');
            $children = $childrenModel->getAllByParent($menuItemId);
            foreach ($children as $singleChild) {
                $menuModel->getOneBy('id', $singleChild['id']);
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
        $menuItem = $menuModel->getOneBy('id', $id);
        $current_position = $menuItem->position;
        $nearItem = $menuModel->getNextItem($direction, $menuItem->admin, $menuItem->parent, $current_position);
        if ($nearItem['position'] > 0 && $menuItem->position > 0) {
            $menuItem->setPosition($nearItem['position']);
            $menuItem->flush();
            $swapItem = $menuModel->getOneBy('id', $nearItem['id']);
            $swapItem->setPosition($current_position);
            $swapItem->flush();
        }
        $this->tools->log('menu', "Menu item with id: $id moved $direction.");
        $this->tools->redirect(URL . 'menu');
    }
}
