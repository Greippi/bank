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
    
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Account');
        }
        return $this->_dbTable;
    }
    
    public function save(Application_Model_Account $account)
    {
        /*$data = array(
            'email'   => $guestbook->getEmail(),
            'comment' => $guestbook->getComment(),
            'created' => date('Y-m-d H:i:s'),
        );
 
        if (null === ($id = $guestbook->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }*/
    }
    
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Account();
            
            $entry->setId($row->account_id)
                  ->setBalance($row->balance)
                  ->setOwner($row->owner);
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function fetchAccount($id) {  
        $entry = NULL;        
        $table = $this->getDbTable();
        $rows = $table->find((int)$id);
        if(isset($rows))
        {
            foreach ($rows as $row) {  
                $entry = new Application_Model_Account();
                $entry->setId($row->account_id)
                      ->setBalance($row->balance)
                      ->setOwner($row->owner);
            }
            return $entry;
        }
    }  
    
    public function updateAccount($id, $balance) {    
        $table = $this->getDbTable();        
        $data = array(
            'balance' => $balance
        );
        $where['account_id = ?'] = $id;
        $table->update($data, $where);
    }  
}

