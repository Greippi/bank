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
    
    public function getSessionDbTable()
    {
        if (null === $this->_dbSessionTable) {
            $this->setSessionDbTable('Application_Model_DbTable_Session');
        }
        return $this->_dbSessionTable;
    }
    
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
 
    public function sessionAuthentication($accountId,$sessionId) {  
        
        try{                        
            $table = $this->getSessionDbTable();
            $query = $table->select()
                   ->where('account_id = :p1')                    
                   ->where('session = :p2')
                   ->where('TIME_TO_SEC(timediff(now(),valid)) / 60 <  500000')                    
                   ->bind(array('p1'=>$accountId,'p2'=>$sessionId));
            $row = $table->fetchRow($query);  
            
            
            //update time stamp and return ok
            if(!isset($row))
            {
                $row->valid = new Zend_Db_Expr('NOW()');
                $row->save();
                return KSoft_ErrorCodes::AUTH_OK;
            }
        } catch (Exception $e) {
            echo $e;
            die;
            error_log ('BANK::ERROR: '.$e, 0);            
            return KSoft_ErrorCodes::ERR_AUTH_UNKNOWN_ERROR;    
        }
    }  

    public function loginAuthentication($accountId,$loginName,$password,$operator) {  
        $result = array('status'=>  KSoft_ErrorCodes::ERR_AUTH_UNKNOWN, 'sessionid'=>"");
        $db = Zend_Db_Table::getDefaultAdapter();                            
        try{      
            $userTable = $this->getUserDbTable();
            $sessionTable = $this->getSessionDbTable();            
            
            $query = $userTable->select()
                   ->where('loginname = :p1')
                   ->where('passwordhash = :p2')                    
                   ->where('accountid = :p3')                                        
                   ->bind(array('p1'=>$loginName,'p2'=>$password, 
                       'p3'=>$accountId));
            
            $row = $userTable->fetchRow($query);                
            if(!isset($row))
                return $result;
            
            $db->beginTransaction();                        
            //Delete old session if exists and create new one
            $query = $sessionTable->select()
                   ->where('originator = :p1')
                   ->where('account_id = :p2')                    
                   ->bind(array('p1'=>$operator,'p2'=>$accountId));
            
            $row = $sessionTable->fetchRow($query);
            if(isset($row))
                $row->delete();

            //insert new session
            $result["sessionid"] = uniqid();
            $result["status"] = KSoft_ErrorCodes::AUTH_OK;            
            $data = array('account_id' => $accountId,
                    'originator' => $operator,
                    'session' => $result["sessionid"]);
            $sessionTable->insert($data);
            $db->commit();
            return $result;
        } catch (Exception $e) {
            $db->rollBack();                        
            error_log ('BANK::ERROR: '.$e, 0);            
        }
    }  
}

?>
