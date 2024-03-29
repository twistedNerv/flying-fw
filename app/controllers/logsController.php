<?php

class logsController extends controller {

    public function __construct() {
        parent::__construct();
    }

    public function indexAction($id = 0) {
        $this->tools->checkPageRights(4);
        $logsModel = $this->loadModel('logs');
        $condition = [
            'search'        => $this->tools->getPost('filter-condition-search'),
            'class'         => $this->tools->getPost('filter-condition-class'),
            'method'        => $this->tools->getPost('filter-condition-method'),
            'type'          => $this->tools->getPost('filter-condition-type'),
            'user'          => $this->tools->getPost('filter-condition-user'),
            'datetime-from' => $this->prepareDate($this->tools->getPost('filter-condition-logs_datetime-from')),
            'datetime-to'   => $this->prepareDate($this->tools->getPost('filter-condition-logs_datetime-to'))
        ];
        $order = [
            'order_by' => $this->tools->getPost('filter-order-by'),
            'order_direction' => $this->tools->getPost('filter-order-direction')
        ];
        $limit = [
            'limit' => $this->tools->getPost('filter-limit-limit')
        ];
        $allLogs = $logsModel->getAllLogsByParams($condition, $order, $limit);
        $allClasses = $logsModel->getAllClasses();
        $allMethods = $logsModel->getAllMethods();
        $allTypes = $logsModel->getAllTypes();
        $allLoggedUsers = $logsModel->getAllLoggedUsers();
        $allConditions = implode(", ", $condition);
        $this->view->assign('logsset', $allLogs);
        $this->view->assign('classset', $allClasses);
        $this->view->assign('methodset', $allMethods);
        $this->view->assign('typeset', $allTypes);
        $this->view->assign('userset', $allLoggedUsers);
        $this->view->render("logs/index");
    }
    
    private function prepareDate($date) {
        if ($date) {
            $tmpDate = explode('-', $date);
            return $tmpDate[2] . "." . $tmpDate[1] . "." . $tmpDate[0];
        }
    }

}
