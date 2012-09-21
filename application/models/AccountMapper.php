<?php

class Application_Model_AccountMapper
{
    protected $_dbTable;
    
     public function setDbTable($dbTable)
     {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
    
    /**
     * 
     * @return Application_Model_DbTable_Account
     */
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Account');
        }
        return $this->_dbTable;
    }
    
    public function save(Application_Model_Account $account)
    {
    }
    
    public function fetcAllAccounts(Application_Model_User $user) {
        
        $userMapper = new Application_Model_UserMapper();
        
        $table = $this->getDbTable();
        
        $query = $table->select()
                       ->where('user_id = :uid')
                       ->bind(array('uid' => $user->id));
        
        $resultSet = $table->fetchAll($query);
        
        $accounts = array();
        
        foreach ($resultSet as $row) {            
            $user = $userMapper->get($row->user_id);            
            $accounts[] = Application_Model_Account::toModel($row);                        
        }
        
        return $accounts;        
    }
    
    public function fetchAll() {
        
        $userMapper = new Application_Model_UserMapper();
        
        $resultSet = $this->getDbTable()->fetchAll();      
        $accounts = array();
        
        foreach ($resultSet as $row) {            
            $user = $userMapper->get($row->user_id);
            
            $account = new Application_Model_Account();

            $account->setId($row->account_id)
                  ->setBalance($row->balance)
                  ->setUser($user);
            
            $accounts[] = $account;
        }
        
        return $accounts;        
    }
    
    public function fetchAccount(Application_Model_User $user, $accountID) {  
        
        $table = $this->getDbTable();
        
        $query = $table->select()
                       ->where('user_id = :uid')
                       ->where('account_id = :accountid')
                       ->bind(array('uid' => $user->id, 
                                    'accountid' => $accountID));
        
        $resultSet = $table->fetchRow($query);
                
        return Application_Model_Account::toModel($resultSet);
    }
    
    public function updateAccount(Application_Model_Account $account) {    
        $table = $this->getDbTable();
        
        $data = array('balance' => $account->balance);        
        $where['account_id = ?'] = $account->id;
        
        $table->update($data, $where);
    }  
}

