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
        $this->getResponse()->setHttpResponseCode(Kilosoft_ErrorCodes::ERR_HTTP_FAIL);        
        exit('not implemented');
    }

    public function headAction()
    {
        $this->getResponse()->setHttpResponseCode(Kilosoft_ErrorCodes::ERR_HTTP_FAIL);        
        exit('not implemented');
    }

    
    public function getAction()
    {
        $msg = new Kilosoft_AccountInfoMsg();
        $id = $this->_getParam('id');
        if(strval(intval($id)) != strval($id))
        {
            $msg->status = Kilosoft_ErrorCodes::ERR_INVALID_ACCOUNT_ID_PARAM;            
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
            }
            else {
                $msg->status = Kilosoft_ErrorCodes::ERR_ACCOUNT_NOT_FOUND;                            
            }
        }
        $this->view->msg = $msg;        
        $this->_forward('index');
    }
 
    public function newAction() {
        $this->getResponse()->setHttpResponseCode(Kilosoft_ErrorCodes::ERR_HTTP_FAIL);        
        exit('not implemented');
    }
    public function postAction() {
        $this->getResponse()->setHttpResponseCode(Kilosoft_ErrorCodes::ERR_HTTP_FAIL);        
        exit('not implemented');
        
        //$this->getParams() or $this->getParam('yourvar');
        $body = $this->getRequest()->getRawBody();
        $data = Zend_Json::decode($body);
        var_dump($data);
        die;
	$this->_forward('index');
    }
    public function editAction() { 
        $this->getResponse()->setHttpResponseCode(Kilosoft_ErrorCodes::ERR_HTTP_FAIL);        
        exit('not implemented');
    }
    public function putAction() {
        $this->getResponse()->setHttpResponseCode(Kilosoft_ErrorCodes::ERR_HTTP_FAIL);        
        exit('not implemented');
    } 
    public function deleteAction() {
        $this->getResponse()->setHttpResponseCode(Kilosoft_ErrorCodes::ERR_HTTP_FAIL);        
        exit('not implemented');
    }
}

