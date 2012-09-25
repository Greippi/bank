<?php
/**
 * TransactionController
 * 
 * @package controllers
 * @category controllers
 */
class TransactionController extends KSoft_BaseController
{               
    /**
     * List all transactions from all accounts
     *      
     */
    public function indexAction()
    {
        $transactionMapper = new Application_Model_TransactionMapper();
        $accountMapper = new Application_Model_AccountMapper();
        $transactionsArray = array();                                    
        $user = Zend_Registry::get(KSoft_Codes::REGISTRY_USER);
        
        $accounts = $accountMapper->fetcAllAccounts($user);
        
        $order = $this->orderBy(Application_Model_Transaction::keys());
        
        foreach( $accounts as $account ) {            
            $transactions = $transactionMapper->fetchAll($account->id, 
                                                         $order);
            
            foreach( $transactions as $ts ){
                $array = $ts->toArray();            
                $transactionsArray[] = $array;
            }            
        }
        
        $response = array('status' => KSoft_ErrorCodes::AUTH_OK, 
                          'transactions' => $transactionsArray);                
        
        $this->view->msg = $response;
    }

    /**
     * List all transactions from one single account
     */
    public function getAction()
    {               
        $response = new KSoft_TransactionResponse(KSoft_ErrorCodes::ERR_ACCOUNT_NOT_FOUND);
        
        $id = $this->getParam('id');
        
        $transactionMapper = new Application_Model_TransactionMapper();
        $accountMapper = new Application_Model_AccountMapper();
        
        $transactionsArray = array();                                    

        $user = Zend_Registry::get(KSoft_Codes::REGISTRY_USER);        
        
        $account = $accountMapper->fetchAccount($user, $id);
        
        if( $account ) {                    
            $response->status = KSoft_ErrorCodes::AUTH_OK;
            
            $order = $this->orderBy(Application_Model_Transaction::keys());
            $transactions = $transactionMapper->fetchAll($id, 
                                                         $order);

            foreach( $transactions as $ts ){
                $array = $ts->toArray();            
                $transactionsArray[] = $array;
            }
        } 
        
        $response->transactions = $transactionsArray;        
        $this->view->msg = $response->toArray();
    }
    
    /**
     * Deposit or withdraw some money
     */
    public function postAction() {        
        $response = array('status' => KSoft_ErrorCodes::AUTH_OK );                
        
        $transactionMapper = new Application_Model_TransactionMapper();
        
        $operation = $this->getParam('operation');
        $amount = $this->getParam('sum');
        $accountID = $this->getParam('accountid');
        $targetID = $this->getParam('targetid');        
        $description = $this->getParam('description');                             
            
        if(!isset($amount, $accountID, $description, $targetID, $operation )
               || ($operation != 'deposit' && $operation != 'withdraw') ) {
                
            $response['status'] = KSoft_ErrorCodes::ERR_INVALID_PARAMETERS;            
            $this->view->msg = $response;
            
            return;
        }
                
        $user = Zend_Registry::get(KSoft_Codes::REGISTRY_USER);
        
        try {
            if($operation == 'deposit') {
                $amount = abs($amount);            
            } 
            else if($operation == 'withdraw') {
                $amount = -abs($amount);
            }                 
            
            $transactionMapper->createTransaction($user,
                                      $accountID, $targetID, 
                                      uniqid(), $amount, 
                                      $description);   
            
        } catch (Exception $exp) {            
            $response = array('status' => $exp->getCode(), 
                              'info'=> $exp->getMessage() );   
        }
        
        $this->view->msg = $response;
    }

}

