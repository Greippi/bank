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
    
    public function postAction() {
 /*        $body = $this->getRequest()->getRawBody();
        $transaction = Zend_Json::decode($body);
        if(isset($transaction)){
            $this->getResponse()->setHttpResponseCode(200);
        }
        else{
            $this->getResponse()->setHttpResponseCode(406);
            exit( 'Invalid parameters' );
        }
        
        $account = new Application_Model_AccountMapper();
        $data = $account->fetchAccount(1);
        if(!isset($data)){
            $this->getResponse()->setHttpResponseCode(406);
            exit( 'Account not found' );
        }
        $oldBalance = $data->getBalance();
        if($oldBalance < 100){
            $this->getResponse()->setHttpResponseCode(406);
            exit( 'Not enought credit' );
        }*/
        $amount = -100;        
        $id = 1;
        $account = new Application_Model_AccountMapper();
        $data = $account->fetchAccount(1);
        if(!isset($data)){
            $this->getResponse()->setHttpResponseCode(406);
            exit( 'Account not found' );
        }
        $oldBalance = $data->getBalance();        
        if($amount < 0 && ($oldBalance + $amount < 0)){
            $this->getResponse()->setHttpResponseCode(406);
            exit( 'Not enought credit' );
        }
        
        $account->updateAccount($id, $oldBalance + $amount);
        $transaction = new Application_Model_TransactionMapper();
        $transaction->createTransaction($id, $id, uniqid(), $amount, '');
        
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

