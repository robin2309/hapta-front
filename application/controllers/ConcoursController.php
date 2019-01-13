<?php

class ConcoursController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $concours = new Application_Model_Concours();
        $this->view->currentConcours = $concours->getCurrentConcours();
        $this->view->countCurrentConcours = $concours->countCurrentConcours();
        $this->view->upcomingConcours = $concours->getUpcomingConcours();
        $this->view->countUpcomingConcours = $concours->countUpcomingConcours();
        $this->view->headTitle = "Hapta ". Zend_Registry::get('City_Location') ." - Jeux Concours";
    }

    public function detailAction()
    {
        // action body
    }

    public function listAction()
    {        
        $concours = new Application_Model_Concours();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->json->sendJson(array('current'=>$concours->getCurrentConcoursJson(), 'upcoming'=>$concours->getUpcomingConcoursJson()));
    }


}

