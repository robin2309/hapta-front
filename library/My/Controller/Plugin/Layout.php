<?php 

class My_Controller_Plugin_Layout extends Zend_Controller_Plugin_Abstract
{
   public function preDispatch(Zend_Controller_Request_Abstract $request)
   {
      $layout = Zend_Layout::getMvcInstance();
      $view = $layout->getView();
      $concours = new Application_Model_Concours();
      

      $view->countAllConcours = $concours->countAllConcours();
   }
}