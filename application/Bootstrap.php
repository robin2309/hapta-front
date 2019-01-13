<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initPlugins(){
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('My_');
        
        Zend_Controller_Front::getInstance()->registerPlugin(new My_Controller_Plugin_Layout());
    }
    
    protected function _initParams(){
		//$config = Zend_Controller_Front::getInstance()->getParam('bootstrap');
		$customParams = $this->getOption('custom');
		$city = $customParams['location']['city'];
		$homeTitle = $customParams['location']['homepageTitle'];
		$siteAddress = $customParams['location']['sitename'];
		$adj = $customParams['location']['adjective'];
		$otherSites = $customParams['location']['othersites'];
		$email = $customParams['contact']['email'];
		$noReply = $customParams['contact']['noreply'];
		$noReplyPass = $customParams['contact']['noreplypass'];
		$smtp = $customParams['contact']['smtp'];
		$addressAdmin = $customParams['contact']['admin']['mail'];
		$apiGA = $customParams['location']['analytics'];
		$linkFb = $customParams['location']['facebook']['link'];
		$nameFb = $customParams['location']['facebook']['page'];
		$idAppFb = $customParams['location']['facebook']['idapp'];
		$idInsta = $customParams['location']['instagram']['id'];
		$idTwitter = $customParams['location']['twitter']['id'];
		$namePartners = $customParams['location']['partners']['name'];
		$linkPartners = $customParams['location']['partners']['link'];
		Zend_Registry::set('City_Location', $city);
		Zend_Registry::set('Home_Title', $homeTitle);
		Zend_Registry::set('Site_Address', $siteAddress);
		Zend_Registry::set('Adjective', $adj);
		Zend_Registry::set('Other_Sites', $otherSites);
		Zend_Registry::set('Contact_Email', $email);
		Zend_Registry::set('Api_GA', $apiGA);
		Zend_Registry::set('Fb_Link', $linkFb);
		Zend_Registry::set('Fb_Name', $nameFb);
		Zend_Registry::set('Fb_Id_App', $idAppFb);
		Zend_Registry::set('No_Reply_Email', $noReply);
		Zend_Registry::set('No_Reply_Pass', $noReplyPass);
		Zend_Registry::set('Smtp_Host', $smtp);
		Zend_Registry::set('Id_Insta', $idInsta);
		Zend_Registry::set('Id_Twitter', $idTwitter);
		Zend_Registry::set('Name_Partners', $namePartners);
		Zend_Registry::set('Link_Partners', $linkPartners);
		Zend_Registry::set('Address_Admin', $addressAdmin);
	}

}

