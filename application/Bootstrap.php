<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initRestRoute()
    {
        $router = Zend_Controller_Front::getInstance ()->getRouter ();
        $router->addRoute('rest_url', new Zend_Controller_Router_Route('account/:accountid/', array( 'module'=>'ModuleName', 'controller' => 'account', 'action' => 'info', 'accountid' => '-1')));                



        
/*        
	$this->bootstrap('Request');	
	$front = $this->getResource('FrontController');
        
        $restRoute = new Zend_Rest_Route($front);
        $front->getRouter()->addRoute('default', $restRoute);

        
	$restRoute = new Zend_Rest_Route($front, array(), array(
            'default' => array('account')));
	$front->getRouter()->addRoute('rest', $restRoute);        

        $restRoute = new Zend_Rest_Route($front, array(), array(
		'version' => array('version')
	));
	$front->getRouter()->addRoute('rest', $restRoute);

        $restRoute = new Zend_Rest_Route($front, array(), array(
            'transaction' => array('transaction')
	));
	$front->getRouter()->addRoute('rest', $restRoute);                */
    } 
 
    protected function _initRequest()
    {
        $this->bootstrap('FrontController');
        $front = $this->getResource('FrontController');
        $request = $front->getRequest();
    	if (null === $front->getRequest()) {
            $request = new Zend_Controller_Request_Http();
            $front->setRequest($request);
        }
    	return $request;        
    } 		

}

