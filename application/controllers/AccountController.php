<?php
/**
 * AccountController gives access to user accounts.
 *  
 * @package controllers
 * @category controllers
 */
class AccountController extends KSoft_BaseController
{        
    /**
     * Return response array for view object
     * 
     * @param array $accounts
     * @return array response
     */
    private function response($accounts) {
        return array('status' => $accounts ? KSoft_ErrorCodes::HTTP_OK : 
                                      KSoft_ErrorCodes::ERR_ACCOUNT_NOT_FOUND, 
                     'accounts' => $accounts);
    }
    
    /**
     * Return all session owner accounts.
     */
    public function indexAction() {                                               
        $user = Zend_Registry::get(KSoft_Codes::REGISTRY_USER);
                
        
        $accountMapper = new Application_Model_AccountMapper();            
        $accounts = $accountMapper->fetcAllAccounts($user);

        $accountsArray = array();

        foreach( $accounts as $account ) {                
            $accountsArray[]= $account->toArray();
        }
               
        $this->view->msg = $this->response($accountsArray);     
    }
    
    /**
     * Return single account information. Only grants access to user owned accounts.
     */
    public function getAction()
    {
        $user = Zend_Registry::get(KSoft_Codes::REGISTRY_USER);
        
        $accountID = $this->getParam('id');
        
        $accountMapper = new Application_Model_AccountMapper();            
        $account = $accountMapper->fetchAccount($user, $accountID);        
        
        $accountsArray = array();
        
        if( $account ) {
            $accountsArray[]= $account->toArray();
        }                
        
        $this->view->msg = $this->response($accountsArray); 
    }
}

