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
        $this->getResponse()->setHttpResponseCode(500);        
        exit('not implemented');
    }
 
    public function getAction()
    {
        $msg = new Kilosoft_TransactionInfoMsg();
        $id = $this->_getParam('id');
        if(strval(intval($id)) != strval($id))
        {
            $msg->status = 406;            
            $this->_forward('index');            
        }
        else 
        {
            $transactions = new Application_Model_TransactionMapper();
            $data = $transactions->fetchTransactionsById($id);    
            if(isset($data) && count($data) > 0)
            {
                $msg->status = 200;            
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
        $this->view->msg = $msg;        
        $this->_forward('index');
    }
 
    public function newAction() { 
        $this->getResponse()->setHttpResponseCode(500);        
        exit('not implemented');
    }
    
    //Example for getting request headers
/*    public function preDispatch()
    {
        $request = new Zend_Controller_Request_Http();
        $key = $request->getHeader('x-apikey');
    }*/

    
    
    public function postAction() {
        //Try first with header parameters
        //Apache way to do it $action = $this-> getFrontController()-> getRequest()->getHeader('operation');        
        $request = new Zend_Controller_Request_Http();
        $action = $request->getHeader('operation');
        $amount = $request->getHeader('sum');
        $accountId = $request->getHeader('accountid');
        $description = $request->getHeader('description');        
        
        //Then try with post parameters        
        if(!isset($operation) || empty($operation))
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
            $this->getResponse()->setHttpResponseCode(406);
            exit( 'Invalid or missing parameters' );
        }
        if(strval(intval($accountId)) != strval($accountId))
        {
            $this->getResponse()->setHttpResponseCode(406);
            exit( 'Invalid account ID parameter' );            
        }
        if(strval(floatval($accountId)) != strval($accountId))
        {
            $this->getResponse()->setHttpResponseCode(406);
            exit( 'Invalid sum parameter' );            
        }
        if($action != 'withdraw' && $action != 'deposit')
        {
            $this->getResponse()->setHttpResponseCode(406);
            exit( 'Invalid operation type parameter' );            
        }
        
        if($action == 'withdraw'){
            $amount = -$amount;
        }

        $account = new Application_Model_AccountMapper();
        $data = $account->fetchAccount($accountId);
        if(!isset($data)){
            $this->getResponse()->setHttpResponseCode(406);
            exit( 'Account not found' );
        }

        $oldBalance = $data->getBalance();        
        if($amount < 0 && ($oldBalance + $amount < 0)){
            $this->getResponse()->setHttpResponseCode(406);
            exit( 'Not enought credit' );
        }
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            $account->updateAccount($accountId, $oldBalance + $amount);
            $transaction = new Application_Model_TransactionMapper();
            $transaction->createTransaction($accountId, $accountId, uniqid(), $amount, $description);
            $db->commit();        
        } catch (Exception $e) {
            error_log ('BANK::ERROR: '.$e, 0);                        
            $db->rollBack();                    
            $this->getResponse()->setHttpResponseCode(500);
            exit( 'Failed to save to database' );            
        }
        
        
        $this->getResponse()->setHttpResponseCode(200);        
        exit();
    }
    
    public function editAction() {    	 
        $this->getResponse()->setHttpResponseCode(500);        
        exit('not implemented');
    }
    public function putAction() {
        $this->getResponse()->setHttpResponseCode(500);        
        exit('not implemented');
    } 
    public function deleteAction() {
        $this->getResponse()->setHttpResponseCode(500);        
        exit('not implemented');
    }

    public function headAction()
    {
        $this->getResponse()->setHttpResponseCode(500);        
        exit('not implemented');
    }
    
}

