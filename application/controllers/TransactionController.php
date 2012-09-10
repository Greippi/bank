<?php

class TransactionController extends Zend_Rest_Controller
{
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
        $msg = new KSoft_TransactionInfoMsg();
        $this->view->msg = $msg;                
        $id = $this->_getParam('id');
        if(strval(intval($id)) != strval($id))
        {
            $msg->status = KSoft_ErrorCodes::ERR_INVALID_ACCOUNT_ID_PARAM;            
        }
        
        try
        {
            $transactions = new Application_Model_TransactionMapper();
            $data = $transactions->fetchTransactionsById($id);    
        }
        catch(OutOfBoundsException $e){
            $msg->status = KSoft_ErrorCodes::ERR_ACCOUNT_NOT_FOUND;
            $this->render();            
        }
        if(isset($data) && count($data) > 0)
        {
            foreach ($data as $item) {  
                $entry = array(
                    'id' => $item->getId(),
                    'account' => $item->getAccount(),
                    'target' => $item->getTarget(),                
                    'reference' => $item->getReference(), 				  
                    'amount' => $item->getAmount(), 				                      
                    'description' => $item->getDescription(), 				                                          
                    'done' => $item->getDone()); 				                                                              
                $entries[] = $entry;                
            }
            $msg->transactions = $entries;
        }
    }
 
    public function newAction() { 
        $this->getResponse()->setHttpResponseCode(KSoft_ErrorCodes::ERR_HTTP_FAIL);        
        exit('not implemented');
    }
    
    //Example for getting request headers
/*    public function preDispatch()
    {
        $request = new Zend_Controller_Request_Http();
        $key = $request->getHeader('x-apikey');
    }*/

    
    
    public function postAction() {
        throw new KSoft_KErrorTest('ÖRGÖRG');        
        
        $msg = new KSoft_ResponseMsg();
        $this->view->msg = $msg;         

        //Try first with header parameters
        //Apache way to do it $action = $this-> getFrontController()-> getRequest()->getHeader('operation');        
        $request = new Zend_Controller_Request_Http();
        $action = $request->getHeader('operation');
        $amount = $request->getHeader('sum');
        $accountId = $request->getHeader('accountid');
        $description = $request->getHeader('description');        

        //Then try with post parameters        
        if(!isset($action) || empty($action))
            $action = $this->getRequest()->getParam('operation');
        if(!isset($amount) || empty($amount))            
            $amount = $this->getRequest()->getParam('sum');
        if(!isset($accountId) || empty($accountId))                    
            $accountId = $this->getRequest()->getParam('accountid');
        if(!isset($description) || empty($description))                    
            $description = $this->getRequest()->getParam('description');        
        if(!isset($description) || empty($description))
            $description = '';
        
        if(!isset($action) || !isset($amount) || !isset($accountId)){
            $msg->status = KSoft_ErrorCodes::ERR_INVALID_PARAMETERS;
            $this->render();            
        }
        if(strval(intval($accountId)) != strval($accountId))
        {
            $msg->status = KSoft_ErrorCodes::ERR_INVALID_ACCOUNT_ID_PARAM;
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
        $transaction = new Application_Model_TransactionMapper();
        $transaction->createTransaction($accountId, $accountId, uniqid(), $amount, $description);
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

