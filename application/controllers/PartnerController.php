<?php

class PartnerController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $partnersNameParam = Zend_Registry::get('Name_Partners');
        $partnersLinkParam = Zend_Registry::get('Link_Partners');
        $partnersName = explode(", ", $partnersNameParam);
        $partnersLink = explode(", ", $partnersLinkParam);
        $partners = array();
        foreach($partnersName as $key=>$name){
	        $partnerToAdd = array('name' => $name, 'link'=>$partnersLink[$key]);
	        $partners[] = $partnerToAdd;
        }
        $this->view->partners = $partners;
    }


}

