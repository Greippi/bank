<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AuthenticationController
 *
 * 
 */
class AuthenticationController  extends Zend_Rest_Controller{
    public function init()
    {
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
        
        $this->_helper->contextSwitch()
                      ->addActionContext('post', array('html', 'xml', 'json'))
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

    public function responseAction()
    {
    }
    
    public function listAction()
    {
        $this->getResponse()->setHttpResponseCode(KSoft_ErrorCodes::ERR_HTTP_FAIL);        
        exit('not implemented');
    }
 
    public function getAction()
    {
        $this->getResponse()->setHttpResponseCode(KSoft_ErrorCodes::ERR_HTTP_FAIL);        
        exit('not implemented');
    }
 
    public function newAction() { 
        $this->getResponse()->setHttpResponseCode(KSoft_ErrorCodes::ERR_HTTP_FAIL);        
        exit('not implemented');
    }
    
    public function postAction() {
        $msg = new KSoft_ResponseMsg();
        $this->view->msg = $msg;    
        $msg->status = KSoft_ErrorCodes::ERR_AUTH_UNKNOWN;

        //Try first with header parameters
        //Apache way to do it $action = $this-> getFrontController()-> getRequest()->getHeader('operation');        
        $request = new Zend_Controller_Request_Http();
        $accountId = $request->getHeader('accountid');        
        $loginName = $request->getHeader('login');
        $password = $request->getHeader('password');
        $operator = $request->getHeader('operator');        

        //Then try with post parameters        
        if(!isset($loginName) || empty($loginName))
            $loginName = $this->getRequest()->getParam('login');
        if(!isset($password) || empty($password))            
            $password = $this->getRequest()->getParam('password');
        if(!isset($operator) || empty($operator))            
            $operator = $this->getRequest()->getParam('operator');
        if(!isset($accountId) || empty($accountId))            
            $accountId = $this->getRequest()->getParam('accountid');

        if(!isset($loginName) || !isset($password) || !isset($operator)  
                || !isset($accountId) || $loginName == "" || $password == "" 
                || $operator == "" || $accountId == "" ||
                strval(intval($accountId)) != strval($accountId)){
            $msg->status = KSoft_ErrorCodes::ERR_INVALID_PARAMETERS;
            $this->render();            
        }
        
        $authentication = new Application_Model_AuthenticationMapper();
        $params = $authentication->loginAuthentication($accountId, $loginName, $password, $operator);
        
        if(!isset($params)){
            $msg->status = KSoft_ErrorCodes::ERR_AUTH_UNKNOWN;
            $msg->info = "";            
        }
        else{
            $msg->status = $params["status"];
            $msg->info = $params["sessionid"];
        }
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

    public function headAction()
    {
        $this->getResponse()->setHttpResponseCode(KSoft_ErrorCodes::ERR_HTTP_FAIL);        
        exit('not implemented');
    }
    
}

?>
