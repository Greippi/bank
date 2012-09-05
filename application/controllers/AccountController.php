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
 
    
    /**
     * The index action handles index/list requests; it should respond with a
     * list of the requested resources.
     */ 
    public function indexAction()
    {
        
    }
 
    public function listAction()
    {
        die;
    }
 
    public function getAction()
    {
        $msg = new Kilosoft_AccountInfoMsg();
        $id = $this->_getParam('id');
        if(strval(intval($id)) != strval($id))
        {
            $msg->status = 406;            
        }
        else 
        {
            $account = new Application_Model_AccountMapper();
            $data = $account->fetchAccount($id);    

            if(isset($data) && count($data) > 0)
            {
                $msg->id = $data->getId();
                $msg->owner = $data->getOwner();
                $msg->balance = $data->getBalance();
                $msg->status = 200;
            }
        }
        $this->view->msg = $msg;        
        $this->_forward('index');
    }
 
    public function newAction() {
        die;
	$this->_forward('index');
    }
    public function postAction() {
        //$this->getParams() or $this->getParam('yourvar');
        $body = $this->getRequest()->getRawBody();
        $data = Zend_Json::decode($body);
        var_dump($data);
        die;
	$this->_forward('index');
    }
    public function editAction() { 
        die;
	$this->_forward('index');
    }
    public function putAction() {
        die;
	$this->_forward('index');
    } 
    public function deleteAction() {
        die;
	$this->_forward('index');
    }
}

