
<?php
class TestController extends Zend_Rest_Controller{
    public function getAction(){
        $datax = array(
            'userID'      => 'a7664093-502e-4d2b-bf30-25a2b26d6021',
            'itemKind'    => 0,
            'value'       => 1,
            'description' => 'Boa saudaÁ„o.',
            'itemID'      => '03e76d0a-8bab-11e0-8250-000c29b481aa'
            
        );

        $json = json_encode($datax);
        $client = new Zend_Http_Client('http://localhost:10082/transaction/?format=json');
        $data = $client->setRawData($json, 'application/json')->request('post');        
        var_dump($data);
        die;
        //$client->setRawData($json, 'application/json')->request('get');
        exit;
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
    public function postAction()
    {
        
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
