<?php

class EventsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function listAction()
    {
        $event = new Application_Model_Event();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->json->sendJson(array('events'=>$event->getUpcomingEventsJson(), 'dates'=>$event->getNbEventsJson()));
    }

    public function moreAction()
    {
    	$this->_helper->viewRenderer->setNoRender(true);
        $dateLast = $this->_getParam('last', 0);
        if($dateLast != 0){
	        $event = new Application_Model_Event();
	        $this->_helper->json->sendJson(array('events'=>$event->getUpcomingEventsMoreJson($dateLast), 'dates'=>$event->getNbEventsMoreJson($dateLast)));
        }
    }

    public function detailAction()
    {
    	//$this->_helper->viewRenderer->setNoRender(true);
        $id = $this->_getParam('id',0);
        if($id > 0){
	        $event = new Application_Model_Event();
	        $this->view->event = $event->getEventDetails($id);
	        $idSpot = $this->view->event->getSpot()->getId();
	        $this->view->pastEventsFromClub = $event->getFivePastEventsFromClub($idSpot);
	        $this->view->upcomingEventsFromClub = $event->getFiveUpcomingEventsFromClub($idSpot);
        }else{
	        throw new Zend_Controller_Action_Exception('Oops, erreur !!', 500);
        }
    }

}