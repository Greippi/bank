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
 
    
    public function jeeAction()
    {
        $this->_forward('index');
    }
    
    /**
     * The index action handles index/list requests; it should respond with a
     * list of the requested resources.
     */ 
    public function indexAction()
    {
		//if you want to have access to a particular paramater use the helper function as follows:
		//print $this->_helper->getParam('abc');
               //To test with this use:  http://myURL/format/xml/abc/1002
    }
 
    public function listAction()
    {
        $this->_forward('index');
    }
 
    public function getAction()
    {
		$this->_forward('index');
    }
 
    public function newAction() {   	
		$this->_forward('index');
    }
    public function postAction() {
		$this->_forward('index');
    }
    public function editAction() {    	 
		$this->_forward('index');
    }
    public function putAction() {
		$this->_forward('index');
    } 
    public function deleteAction() {
		$this->_forward('index');
    }
}

