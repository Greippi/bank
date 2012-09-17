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
         ->addActionContext('get', array('html','xml', 'json'))
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
        $this->getResponse()->setHttpResponseCode(KSoft_ErrorCodes::ERR_HTTP_FAIL);        
        exit('not implemented');
    }

    public function headAction()
    {
        $this->getResponse()->setHttpResponseCode(KSoft_ErrorCodes::ERR_HTTP_FAIL);        
        exit('not implemented');
    }

    
    public function getAction()
    {
        $msg = new KSoft_AccountInfoMsg();
        $this->view->msg = $msg;                
        $id = $this->_getParam('id');
        $sessionId = $this->_getParam('sessionid');
        if(!isset($sessionId) || $sessionId == "")
        {
            $msg->status = KSoft_ErrorCodes::ERR_AUTH_UNKNOWN;            
            $this->render();
            exit();            
        }
        
        if(strval(intval($id)) != strval($id))
        {
            $msg->status = KSoft_ErrorCodes::ERR_INVALID_ACCOUNT_ID_PARAM;            
            $this->render(); 
        }
        
        //Check valid session
        $authentication = new Application_Model_AuthenticationMapper();
        $status = $authentication->sessionAuthentication($id, $sessionId);
        if($status != KSoft_ErrorCodes::AUTH_OK){
            $msg->status = $status;
            $this->render();
        }
        
        $account = new Application_Model_AccountMapper();
        $data = $account->fetchAccount($id);    

        if(isset($data) && count($data) > 0)
        {
            $msg->id = $data->getId();
            $msg->owner = $data->getOwner();
            $msg->balance = $data->getBalance();
        }
        else {
            $msg->status = KSoft_ErrorCodes::ERR_ACCOUNT_NOT_FOUND;                            
        }
    }
 
    public function newAction() {
        $this->getResponse()->setHttpResponseCode(KSoft_ErrorCodes::ERR_HTTP_FAIL);        
        exit('not implemented');
    }
    public function postAction() {
        $this->getResponse()->setHttpResponseCode(KSoft_ErrorCodes::ERR_HTTP_FAIL);        
        exit('not implemented');
        
        //$this->getParams() or $this->getParam('yourvar');
        $body = $this->getRequest()->getRawBody();
        $data = Zend_Json::decode($body);
    }
    public function editAction() { 
        $this->getResponse()->setHttpResponseCode(KSoft_ErrorCodes::ERR_HTTP_FAIL);        
        exit('not implemented');
    }
    public function putAction() {
        $this->getResponse()->setHttpResponseCode(KSoft_ErrorCodes::ERR_HTTP_FAIL);        
        exit('not implemented');
    } 
    public function deleteAction() {
        $this->getResponse()->setHttpResponseCode(KSoft_ErrorCodes::ERR_HTTP_FAIL);        
        exit('not implemented');
    }
}

