<?php

class PrefsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        $this->view->headTitle = "Hapta ". Zend_Registry::get('City_Location') ." - Préférences";
        $idUserFb = $request->getCookie('idUserFbHapta');
        if(!(is_null($idUserFb))){
        	
        	$this->view->loggedIn = true;
	        if($request->isPost()){
	        	$formData = $request->getPost();
	        	$data= array(
	        		'email' => $formData['email'],
	        		'firstName' => $formData['firstName'],
	        		'familyName' => $formData['familyName']
	        	);
	        	$user = new Application_Model_User();
	        	$user->editUserInfo($data, $idUserFb);
	        	$user = new Application_Model_User();
	        	$this->view->dataPopulate = $user->getUserInfo($idUserFb);
	        	//$this->_redirect('index');
	        	//$this->_helper->viewRenderer->setNoRender(true);
	        } else {
	        	$user = new Application_Model_User();
	        	$this->view->dataPopulate = $user->getUserInfo($idUserFb);
	        }
        } else {
	        $this->view->loggedIn = false;
        }
        
        
    }


}

