<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $events = new Application_Model_Event();
        $this->view->upcomingEvents = $events->getUpcomingEvents();
        $this->view->nbEventsByDate = $events->getNbEvents();
        $this->view->headTitle = "Hapta ". Zend_Registry::get('City_Location') ." - ". Zend_Registry::get('Home_Title');
        $this->view->linkFb = Zend_Registry::get('Fb_Link');
        $this->view->pageFb = Zend_Registry::get('Fb_Name');
    }

    public function moreeventsAction()
    {
        $events = new Application_Model_Event();
        $request = $this->getRequest();
        //if($request->isXmlHttpRequest()){
        	$dateLast = $this->_getParam('last', 0);
	        $this->view->upcomingEvents = $events->getUpcomingEventsMore($dateLast);
	        //var_dump($this->view->upcomingEvents);
	        $this->view->nbEventsByDate = $events->getNbEventsMore($dateLast);
	        $this->_helper->getHelper('layout')->disableLayout();
	        //$this->_helper->viewRenderer->setNoRender(true);
        //}else{
	    //    throw new Zend_Controller_Action_Exception('Oops, erreur !!', 404);
        //}
    }

    public function searcheventsAction()
    {
        $events = new Application_Model_Event();
        $request = $this->getRequest();
        if($request->isXmlHttpRequest()){
        	$query = $this->_getParam('input', 0);
        	$this->view->foundEvents = $events->getEventsFromSearch($query);
        	$this->_helper->getHelper('layout')->disableLayout();
        }else{
	        throw new Zend_Controller_Action_Exception('Oops, erreur !!', 404);
        }
    }

    public function initeventsAction()
    {
        $events = new Application_Model_Event();
        $request = $this->getRequest();
        if($request->isXmlHttpRequest()){
        	$this->view->upcomingEvents = $events->getUpcomingEvents();
        	$this->view->nbEventsByDate = $events->getNbEvents();
        	$this->_helper->getHelper('layout')->disableLayout();
        }else{
	        throw new Zend_Controller_Action_Exception('Oops, erreur !!', 404);
        }
    }

    public function searcheventsdateAction()
    {
	    $events = new Application_Model_Event();
        $request = $this->getRequest();
        if($request->isXmlHttpRequest()){
        	$query = $this->_getParam('date', 0);
        	$this->view->foundEvents = $events->getEventsFromSearchDate($query);
	        $this->view->nbEventsByDate = $events->getNbEvents($query);
        	$this->_helper->getHelper('layout')->disableLayout();
        }else{
	        throw new Zend_Controller_Action_Exception('Oops, erreur !!', 404);
        }
    }

    public function moreeventsflyerAction()
    {
        $events = new Application_Model_Event();
        $request = $this->getRequest();
        if($request->isXmlHttpRequest()){
        	$dateLast = $this->_getParam('last', 0);
	        $this->view->upcomingEvents = $events->getUpcomingEventsMore($dateLast);
	        $this->view->nbEventsByDate = $events->getNbEventsMore($dateLast);
	        $this->_helper->getHelper('layout')->disableLayout();
        }else{
	        throw new Zend_Controller_Action_Exception('Oops, erreur !!', 404);
        }
    }

    public function searcheventsartistAction()
    {
        $events = new Application_Model_Event();
        $request = $this->getRequest();
        if($request->isXmlHttpRequest()){
        	$query = $this->_getParam('input', 0);
        	$this->view->foundEvents = $events->getEventsFromSearchArtist($query);
        	$this->_helper->getHelper('layout')->disableLayout();
        }else{
	        //throw new Zend_Controller_Action_Exception('Oops, erreur !!', 404);
        }
    }


}















