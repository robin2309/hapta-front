<?php

class ErrorController extends Zend_Controller_Action
{

    public function errorAction()
    {
    	$errors = $this->_getParam('error_handler');
        
        if (!$errors || !$errors instanceof ArrayObject) {
            $this->view->message = 'You have reached the error page';
            return;
        }
        $this->view->type = $errors->type;
        
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $priority = Zend_Log::NOTICE;
                $this->view->message = 'Page non trouvée';
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $priority = Zend_Log::CRIT;
                $this->view->message = 'Erreur interne serveur';
                break;
        }
        $this->view->code = $this->getResponse()->getHttpResponseCode();
        
        // Log exception, if logger available
        if ($log = $this->getLog()) {
        	$rqtParameters = str_replace(array("\r","\n"),"",var_export($errors->request->getParams(),true));
            $log->log($this->view->message, $priority, $errors->exception->getMessage());
            $log->log('Request Parameters : '. $rqtParameters, $priority);
        }
        
        // conditionally display exceptions
        // DESACTIVER EN PROD
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $errors->exception;
            $this->view->request   = $errors->request;
        }
        $this->view->headTitle = "Hapta ". Zend_Registry::get('City_Location') ." - Erreur";
        //$this->_helper->getHelper('layout')->disableLayout();
    }

    public function getLog()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasResource('log')) {
            return false;
        }
        $log = $bootstrap->getResource('log');
        return $log;
    }


}

