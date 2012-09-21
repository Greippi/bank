<?php

/**
 * Description of BaseController
 */
class KSoft_BaseController extends Zend_Rest_Controller {
    
    public function init()  {        
        $html = array( 'suffix' => 'html',
                       'headers'   => array('Content-Type' => 'text/html; Charset=UTF-8'));                      
        
        $types = array( 'html', 'xml', 'json' );
        
         $this->_helper->contextSwitch()
                    ->setContext('html',$html )
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
    }
    
    protected function defaultResponse() {
        $this->getResponse()->setHttpResponseCode(KSoft_ErrorCodes::HTTP_NOT_IMPLEMENTED);                        
        $this->view->msg = new KSoft_ResponseMsg(KSoft_ErrorCodes::HTTP_NOT_IMPLEMENTED);        
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
