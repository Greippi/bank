<?php

class AccountController extends Zend_Rest_Controller
{
    public function init()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
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
 
    
    public function infoAction()
    {
        $accountId = $this->_getParam('accountid');
        $account = new Application_Model_AccountMapper();
        $this->view->bankAccount = $account->fetchAccount($accountId);    

        if(isset($this->view->bankAccount))
        {
        }
        $this->_forward('index');
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
        
    }
 
    public function getAction()
    {
/*        //I will return result in XML format.
        $this->getResponse ()->setHeader ( 'Content-Type', 'text/xml' );
   
        //Note: the Request object here is not HttpRequest. It is Zend controller request. This is the key!
        if ($this->getRequest ()->getParam ( "product" ) != NULL and $this->getRequest ()->getParam ( "number") != NULL ) {  
   //Initializing a dummy object for return.
   $return = new Jia_Return ();
   $return->setProducts ( $this->getRequest ()->getParam ( "product" ) );
   $return->setQuantity ( $this->getRequest ()->getParam ( "number" ) );
   //We prevent the product has been found.
   //So, we set HTTP code 200 here. 
   $this->getResponse ()->setHttpResponseCode ( 200 );
  }   
   else {
    $return= new Jia_ErrorCode('no parameters!');
    //prevent the product is not found.
    $this->getResponse ()->setHttpResponseCode ( 200 );
   }
   
  print $this->_handleStruct( $return );
	$this->_forward('index');*/
    }
 
    public function newAction() {   	
	$this->_forward('index');
    }
    public function postAction() {
	$this->_forward('index');
    }
    public function editAction() {    	 
	$this->_forward('index');
    }
    public function putAction() {
	$this->_forward('index');
    } 
    public function deleteAction() {
	$this->_forward('index');
    }
}

