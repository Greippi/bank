<?php

class AccountController extends Zend_Rest_Controller
{
    public function init()
    {
        //$bootstrap = $this->getInvokeArg('bootstrap');
/*	$contextSwitch = $this->_helper->getHelper('contextSwitch');
         ->setAutoJsonSerialization(true)
	$contextSwitch->addActionContext('index', array('xml','json'))->initContext();
         
  */       
        $this->_helper->contextSwitch()
             ->setContext(
             'html', array(
                 'suffix'    => 'html',
                 'headers'   => array(
                     'Content-Type' => 'text/html; Charset=UTF-8',
                 ),
             )
         )
         ->addActionContext('index', array('html','xml', 'json'))
         ->setAutoJsonSerialization(false)
         ->initContext();          
         
    }
 
    
    public function infoAction()
    {
    }
    /**
     * The index action handles index/list requests; it should respond with a
     * list of the requested resources.
     */ 
    public function indexAction()
    {
    }
 
    public function listAction()
    {
        
    }
 
    public function getAction()
    {
        $msg = new Application_Model_AccountMessage();
        $id = $this->_getParam('id');
        $account = new Application_Model_AccountMapper();
        $data = $account->fetchAccount($id);    
        

        if(isset($data))
        {
            $msg->id = $data->getId();
            $msg->owner = $data->getOwner();
            $msg->saldo = $data->getSaldo();
            $msg->status = 200;
        }
        $this->view->msg = $msg;        
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

