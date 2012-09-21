<?php
/**
 * AuthenticationController make auchentications and provide sessionkeys.
 * 
 * @package controllers
 * @category controllers
 */
class AuthenticationController extends KSoft_BaseController {      
            
    /**
     * Return sessionkey POST-action
     */
    public function postAction() {                                   
        $loginName = $this->getParam('login');    
        $password = $this->getParam('password');        
        
        $response = array('status' => 0);
        
        if($loginName && $password) {           
            $authentication = new Application_Model_AuthenticationMapper();             
             $response = $authentication->authenticate($loginName, $password);             
        } else {
             $response['status'] = KSoft_ErrorCodes::ERR_INVALID_PARAMETERS;
        }                        
                        
        $this->view->msg = $response;               
    }       
}
