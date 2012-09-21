<?php
/**
 * SessionCheck plugin
 * 
 * @package Ksoft
 * @category Kilosoft
 */
class KSoft_SessionCheck extends Zend_Controller_Plugin_Abstract {

    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        if( $request->getControllerName() == 'authentication') {
            return;
        }        
        
        $authenticationMapper = new Application_Model_AuthenticationMapper();        
        $sessionkey = $request->getParam('sessionkey');        
            
        $user = $authenticationMapper->sessionAlive($sessionkey);
        Zend_Registry::set(KSoft_Codes::REGISTRY_USER, $user);                       
        
        if(!$user) {                                                
            $request->setControllerName('authentication');
            $request->setActionName('index');
            
            //TODO: Set error code for expiered sessionkey
        }
    }
}
