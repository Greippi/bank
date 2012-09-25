<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserAuthenticationMapper
 *
 * @author reino.hanninen
 */
class Application_Model_AuthenticationMapper {
    
    protected $_dbUserTable;
    protected $_dbSessionTable;    
    
        /**
     * Return Application_Model_DbTable_Session
     * 
     * @param type $dbTable
     * @return Zend_Db_Table_Abstract
     * @throws Exception
     */
    public function getSessionDbTable()
    {
        if (null === $this->_dbSessionTable) {
            $this->setSessionDbTable('Application_Model_DbTable_Session');
        }
        return $this->_dbSessionTable;
    }
    
    /**
     * Return Application_Model_DbTable_User
     * 
     * @param type $dbTable
     * @return Zend_Db_Table_Abstract
     * @throws Exception
     */
    public function getUserDbTable()
    {
        if (null === $this->_dbUserTable) {
            $this->setUserDbTable('Application_Model_DbTable_User');
        }
        return $this->_dbUserTable;
    }
        
    public function setUserDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbUserTable = $dbTable;
        return $this;
    }
    
    public function setSessionDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbSessionTable = $dbTable;
        return $this;
    }
    
    /**
     * Check is session alive, if session alive return session owner.
     * 
     * @param type $sessionkey
     */
    public function sessionAlive($sessionkey) {
        $table = $this->getSessionDbTable();
        
        $now = new Zend_Date(time(), new Zend_Locale('GMT'));  
        $time = $now->toString(KSoft_Codes::MYSQL_TIMESTAMP_FORMAT);
        
        $query = $table->select()
                        ->where('sessionkey = :sessionkey AND valid > :time')
                        ->bind(array('sessionkey'=>$sessionkey, 'time' => $time));
        
       $result = $table->fetchRow($query);
       
       if($result) {
           $usermapper = new Application_Model_UserMapper();           
           return $usermapper->get($result->id);           
       }
       
       return false;
    }
 
    /**
     * Fetch exising sessionkey for user if sessionkey don't exist create new
     * and return that.
     * 
     * @param Application_Model_User $user
     * @return Application_Model_Session
     */
    public function getSession(Application_Model_User $user) {  
        
        $table = $this->getSessionDbTable();
            
        $now = new Zend_Date(time(), new Zend_Locale('GMT'));  
        $time = $now->toString(KSoft_Codes::MYSQL_TIMESTAMP_FORMAT);
        
        $query = $table->select()
                        ->where('user_id = :uid AND valid > :time')
                        ->bind(array('uid'=>$user->id, 'time' => $time));
        
        $result = $table->fetchRow($query);               
        
        if(!$result) {
            $result = $this->createSession($user);
        }
        
        return Application_Model_Session::toModel($result);
    }  
    
    public function createSession(Application_Model_User $user) {          
        $table = $this->getSessionDbTable();          
        
        $config = Zend_Registry::get('config');

        $created = new Zend_Date(time(), new Zend_Locale('GMT'));       
        $valid = $created->addSecond($config->get('kilosoft')->user->sessionexpire);
        
        $created = $created->toString(KSoft_Codes::MYSQL_TIMESTAMP_FORMAT);
        $valid = $valid->toString(KSoft_Codes::MYSQL_TIMESTAMP_FORMAT);
        
        $params = array('user_id'=> $user->id,
                        'created' => $created,
                        'valid'=> $valid,
                        'sessionkey' => uniqid() );                
        
        $id = $table->insert($params);
        
        return $table->fetchRow($table->select()
                                       ->where('id = :sid')
                                       ->bind(array('sid'=>$id)));                
    }  

     /**
     * Authenticate user by login name and by given password. Return a
     * sessionkey if user is authenticated.
     * 
     * @param string $loginname
     * @param string $password md5 hashed password
     * @return array(sessionkey, status)
     */
    public function authenticate( $loginname,$password ) {  
                              
        $response = array('sessionkey'=> false, 'status'=> '');                                           
           
        $userTable = $this->getUserDbTable();                                         
        
        $query = $userTable->select()
                        ->where('passwordhash = MD5(CONCAT( :password, user.passwordsalt )) '
                                . 'AND loginname = :loginname' )

                        ->bind(array('loginname'=>$loginname,
                                     'password'=> $password));        
        
        $result = $userTable->fetchRow($query);    
                      
        if($result) {
            $user = Application_Model_User::toModel($result);            
             $session = $this->getSession($user);
             $response['sessionkey'] = $session->sessionkey;
        }        
         
        if( $response['sessionkey'] ) {
            $response['status'] = KSoft_ErrorCodes::AUTH_OK;
        } else {
            $response['status'] = KSoft_ErrorCodes::ERR_AUTH_UNKNOWN;
        }
        
        return $response;   
    }  
}

?>
