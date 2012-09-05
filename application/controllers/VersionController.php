<?php

class VersionController extends Zend_Rest_Controller
{
    public function init()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
 	$options = $bootstrap->getOption('resources');
 
	$contextSwitch = $this->_helper->getHelper('contextSwitch');
	$contextSwitch->addActionContext('index', array('xml','json'))->initContext();
 
		//$this->_helper->viewRenderer->setNeverRender();	
	$this->view->success = "true";
	$this->view->version = "1.0";
    }
 
    
   
    /**
     * The index action handles index/list requests; it should respond with a
     * list of the requested resources.
     */ 
    public function indexAction()
    {
        $this->getResponse()->setHttpResponseCode(500);        
        exit('not implemented');
		//if you want to have access to a particular paramater use the helper function as follows:
		//print $this->_helper->getParam('abc');
               //To test with this use:  http://myURL/format/xml/abc/1002
    }
 
    public function listAction()
    {
        $this->getResponse()->setHttpResponseCode(500);        
        exit('not implemented');
    }
 
    public function getAction()
    {
        $this->getResponse()->setHttpResponseCode(500);        
        exit('not implemented');
    }
 
    public function newAction() {   	
        $this->getResponse()->setHttpResponseCode(500);        
        exit('not implemented');
    }
    public function postAction() {
        $this->getResponse()->setHttpResponseCode(500);        
        exit('not implemented');
    }
    public function editAction() {    	 
        $this->getResponse()->setHttpResponseCode(500);        
        exit('not implemented');
    }
    public function putAction() {
        $this->getResponse()->setHttpResponseCode(500);        
        exit('not implemented');
    } 
    public function deleteAction() {
        $this->getResponse()->setHttpResponseCode(500);        
        exit('not implemented');
    }

    public function headAction()
    {
        $this->getResponse()->setHttpResponseCode(500);        
        exit('not implemented');

    }
}

