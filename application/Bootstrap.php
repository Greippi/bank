<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initApplication() {
        $config = new Zend_Config($this->getOptions(), false);
        Zend_Registry::set('config', $config);
    }
    
    protected function _initRestRoute()
    {
        $this->bootstrap('frontController');
        $frontController = Zend_Controller_Front::getInstance();            
        $restRoute = new Zend_Rest_Route($frontController);
        $frontController->getRouter()->addRoute('default', $restRoute);
    } 
 
    protected function _initRequest()
    {
        $this->bootstrap('FrontController');
        $front = $this->getResource('FrontController');
        $request = $front->getRequest();
        
    	if(!$request) {
            $request = new Zend_Controller_Request_Http();
            $front->setRequest($request);
        }
        
    	return $request;        
    } 		

    protected function _initSessionCheck() {
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new KSoft_SessionCheck());
    }
    
    protected function initLogger() {
        //TODO: Copy Logger from dumpo
    }
}

