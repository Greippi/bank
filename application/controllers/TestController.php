
<?php
class TestController extends Zend_Rest_Controller{
    public function getAction(){
        //If sending data as raw encode
        //$json = json_encode($datax);
        //$adata = $client->setRawData($json, 'application/json')->request('post');        
        //$client->setRawData($json, 'application/json')->request('get');
        
        $client = new Zend_Http_Client('http://localhost:10082/transaction/');

/*        $client->setMethod(Zend_Http_Client::GET);        
        //$client->setParameterGet("format", "xml");        
        $client->setParameterGet("offset", "0");                
        $client->setParameterGet("limit", "3");                        */
        
        $client->setMethod(Zend_Http_Client::POST);
        $client->setParameterPost('operation', 'withdraw');
        $client->setParameterPost('description', 'ATM withdraw');        
        $client->setParameterPost('sum', '200');
        $client->setParameterPost('accountid', '1');
        $client->setParameterPost('targetid', '2');        
        $response = $client->request();        
        echo $response;
        exit;
    }

    /**
     * The index action handles index/list requests; it should respond with a
     * list of the requested resources.
     */ 
    public function indexAction()
    {
        echo 'perkele';
        $this->rer>_forward('list','test');    
        echo 'jälkeen';
    }
 
    public function listAction()
    {
        echo 'list';
    }
    public function postAction()
    {
        
    }

    public function headAction()
    {
        die;
    }

 
    public function newAction() {   	
    }
    public function editAction() {    	 

    }
    public function putAction() {

    } 
    public function deleteAction() {

    }
}
?>
