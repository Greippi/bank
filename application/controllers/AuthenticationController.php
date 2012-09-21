<?php
/**
 * AuthenticationController make auchentications and provide sessionkeys.
 */
class AuthenticationController extends KSoft_BaseController {      
            
    /**
     * Return sessionkey POST-action
     */
    public function postAction() {                                   
        $loginName = $this->getParam('login');    
        $password = $this->getParam('password');        

        $msg = new KSoft_ResponseMsg();
        
        if($loginName && $password) {           
            $authentication = new Application_Model_AuthenticationMapper();
            $msg->status = $authentication->authenticate($loginName, $password);            
        } else {
            $msg->status = KSoft_ErrorCodes::ERR_INVALID_PARAMETERS;
        }                        
        
        $this->view->msg = $msg;               
    }       
}
