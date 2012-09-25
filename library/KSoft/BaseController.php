<?php

/**
 * Ksoft_BaseController impelements default behavior for the webservice controllers.
 */
class KSoft_BaseController extends Zend_Rest_Controller {
    
    public function init()  {          

        $html = array( 'suffix' => 'html',
                       'headers'   => array('Content-Type' => 'text/html; Charset=UTF-8'));                      
              
        $yaml = array( 'suffix' => 'yaml',                       
                       'headers'   => array('Content-Type' => 'application/yaml; Charset=UTF-8')); 
        
        $csv = array( 'suffix' => 'csv',                       
                       'headers'   => array('Content-Type' => 'application/csv; charset=UTF-8')); 
        
        $types = array( 'json', 'html', 'xml', 'yaml','csv' );
                
        $this->_helper->contextSwitch();
                
        
        $this->_helper->contextSwitch()
                    ->setContext('html', $html)
                    ->addContext('yaml', $yaml)
                    ->addContext('csv', $csv)
                    ->addActionContext('index', $types)
                    ->setAutoJsonSerialization(false)
                    ->initContext();  
        
        $this->_helper->contextSwitch()                    
                    ->addActionContext('get', $types)                     
                    ->setAutoJsonSerialization(false)
                    ->initContext();  
        
        $this->_helper->contextSwitch()
                      ->addActionContext('post', $types )
                      ->setAutoJsonSerialization(false)
                      ->initContext();        

        $this->_helper->viewRenderer('renderer');                 
        
        //Prettyfy XML-format if param 'pretty' = true
        $this->view->format = $this->getParam('pretty') == 'true' ? true : false;
        
        //Allow cross domain ajax request
        $this->getResponse()->setHeader('Access-Control-Allow-Origin', '*');
    }
    
    /**
     * Default responses
     */
    protected function defaultResponse() {
        $this->getResponse()->setHttpResponseCode(KSoft_ErrorCodes::HTTP_NOT_IMPLEMENTED);                        
        $this->view->msg = new KSoft_ResponseMsg(KSoft_ErrorCodes::HTTP_NOT_IMPLEMENTED);        
    }    
        
    protected function orderBy($allowedKeys = array()) {
        
        $order = $this->getParam('order');
        $orderBy = $this->getParam('by');

        if( in_array(strtolower($orderBy),$allowedKeys) 
            && (strtoupper($order) =='DESC' || strtoupper($order) == 'ASC')) {            
            return $orderBy. ' ' . strtoupper($order);
        } else {
            '';
        }                 
    }
    
    public function deleteAction() {
        $this->defaultResponse();
    }

    public function getAction() {
        $this->defaultResponse();
    }

    public function headAction() {
        $this->defaultResponse();
    }

    public function indexAction() {
        $this->defaultResponse();
    }

    public function postAction() {
        $this->defaultResponse();
    }

    public function putAction() {
        $this->defaultResponse();
    }
}

?>
