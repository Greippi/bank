<?php

class TransactionController extends KSoft_BaseController
{   
    public function indexAction()
    {
        $transactionMapper = new Application_Model_TransactionMapper();
        $accountMapper = new Application_Model_AccountMapper();
        $transactionsArray = array();                                    
        $user = Zend_Registry::get(KSoft_Codes::REGISTRY_USER);
        
        $accounts = $accountMapper->fetcAllAccounts($user);
        
        foreach( $accounts as $account ) {            
            $transactions = $transactionMapper->fetchAll($account->id);
            
            foreach( $transactions as $ts ){
                $array = $ts->toArray();            
                $transactionsArray[] = $array;
            }            
        }
        
        $response = array('status' => KSoft_ErrorCodes::AUTH_OK, 
                          'transactions' => $transactionsArray);
        
        $this->view->msg = $response;
    }

    
    public function postAction() {
        $msg = new KSoft_ResponseMsg();
        $this->view->msg = $msg;    
        $limit = NULL;
        $offset = NULL;

        //Try first with header parameters
        //Apache way to do it $action = $this-> getFrontController()-> getRequest()->getHeader('operation');        
        $request = new Zend_Controller_Request_Http();
        $action = $request->getHeader('operation');
        $amount = $request->getHeader('sum');
        $accountId = $request->getHeader('accountid');
        $targetId = $request->getHeader('targetid');        
        $description = $request->getHeader('description');     
        $sessionId = $request->getHeader('sessionid');

        //Then try with post parameters        
        if(!isset($action) || empty($action))
            $action = $this->getRequest()->getParam('operation');
        if(!isset($amount) || empty($amount))            
            $amount = $this->getRequest()->getParam('sum');
        if(!isset($accountId) || empty($accountId))                    
            $accountId = $this->getRequest()->getParam('accountid');
        if(!isset($targetId) || empty($targetId))                    
            $targetId = $this->getRequest()->getParam('targetid');
        if(!isset($description) || empty($description))                    
            $description = $this->getRequest()->getParam('description');        
        if(!isset($sessionId) || empty($sessionId))
            $sessionId = $this->getRequest()->getParam('sessionid');        

        
        if(!isset($sessionId) || $sessionId == "")
        {
            $msg->status = KSoft_ErrorCodes::ERR_AUTH_UNKNOWN;            
            $this->render();
        }
        
        if(!isset($action) || !isset($amount) || !isset($accountId) || !isset($targetId)){
            $msg->status = KSoft_ErrorCodes::ERR_INVALID_PARAMETERS;
            $this->render();            
        }
        if(strval(intval($accountId)) != strval($accountId))
        {
            $msg->status = KSoft_ErrorCodes::ERR_INVALID_ACCOUNT_ID_PARAM;
            $this->render();            
        }
        
        //Check valid session
        $authentication = new Application_Model_AuthenticationMapper();
        $status = $authentication->sessionAuthentication($accountId, $sessionId);
        if($status != KSoft_ErrorCodes::AUTH_OK){
            $msg->status = $status;
            $this->render();
        }
        
        if(strval(floatval($amount)) != strval($amount))
        {
            $msg->status = KSoft_ErrorCodes::ERR_INVALID_AMOUNT_PARAM;
            $this->render();            
        }
        
        if($action != 'withdraw' && $action != 'deposit')
        {
            $msg->status = KSoft_ErrorCodes::ERR_INVALID_ACTION_PARAM;
            $this->render();            
        }
        
        if($action == 'withdraw'){
            $amount = -$amount;
        }
        
        $account = new Application_Model_AccountMapper();
        $data = $account->fetchAccount($accountId);
        if(!isset($data)){
            $msg->status = KSoft_ErrorCodes::ERR_ACCOUNT_NOT_FOUND;
            $this->render();            
        }
        $oldBalance = $data->getBalance();        
        if(($amount < 0) && (($oldBalance + $amount) <= 0)){
            $msg->status = KSoft_ErrorCodes::ERR_INSUFFICIENT_BALANCE;
            $this->render();
        }
        
        
        if($accountId != $targetId){
            $data = $account->fetchAccount($targetId);
            if(!isset($data)){
                $msg->status = KSoft_ErrorCodes::ERR_ACCOUNT_NOT_FOUND;
                $this->render();            
            }        
        }
        
        $transaction = new Application_Model_TransactionMapper();
        $transaction->createTransaction($accountId, $targetId, uniqid(), $amount, $description);
    }    
}

