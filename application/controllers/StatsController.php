<?php

class StatsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->view->headTitle = "Hapta ". Zend_Registry::get('City_Location') ." - Statistiques";
    }


}

