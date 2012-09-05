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
        die;
        $this->_forward('index');
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
        die;
        $this->_forward('index');
    }
    
    public function postAction() {
        $body = $this->getRequest()->getRawBody();
        $data = Zend_Json::decode($body);
        echo var_dump($data);
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

