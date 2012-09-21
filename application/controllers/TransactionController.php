<?php
/**
 * TransactionController
 * 
 * @package controllers
 * @category controllers
 * 
 * TODO: Add limit, order, order by, offset and default limit
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
        
        foreach( $accounts as $account ) {            
            $transactions = $transactionMapper->fetchAll($account->id);
            
            foreach( $transactions as $ts ){
                $array = $ts->toArray();            
                $transactionsArray[] = $array;
            }            
        }
        
        //FIXME: Arrange transaction by accountID
        $response = array('status' => KSoft_ErrorCodes::AUTH_OK, 
                          'transactions' => $transactionsArray);
        
        $this->view->msg = $response;
    }

    /**
     * List all transactions from one single account
     */
    public function getAction()
    {
        $id = $this->getParam('id');
        
        $transactionMapper = new Application_Model_TransactionMapper();
        $accountMapper = new Application_Model_AccountMapper();
        
        $transactionsArray = array();                                    

        $user = Zend_Registry::get(KSoft_Codes::REGISTRY_USER);        
        
        if( $accountMapper->fetchAccount($user, $id) ) {                    
            $transactions = $transactionMapper->fetchAll($id);

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

