<?php

class Application_Model_TransactionMapper
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
            $this->setDbTable('Application_Model_DbTable_Transaction');
        }
        return $this->_dbTable;
    }
    
    public function save(Application_Model_Transaction $Transaction)
    {
    }

    
    public function fetchAll() {
        try{
            $resultSet = $this->getDbTable()->fetchAll();
            $entries   = array();
            foreach ($resultSet as $row) {
                $entry = new Application_Model_Transaction();
            
                $entry->setId($row->transaction_id)
                        ->setAccount($row->account)
                        ->setTarget($row->target)
                        ->setReference($row->reference)			
                        ->setAmount($row->amount)
                        ->setDescription($row->description)
                        ->setDone($row->done);
                $entries[] = $entry;
            }
            return $entries;
        } catch (Exception $e) {
            error_log ('BANK::ERROR: '.$e, 0);
            return NULL;
        }
    }
    
    public function fetchTransactionsById($id, $offset, $limit) {
        $entries = NULL;                    
        $loc_offset = 0;
        $loc_limit = 10;
        
        //Check if account exists        
        $account = new Application_Model_AccountMapper(); 
        $data = $account->fetchAccount($id);
        if(!isset($data))
            throw new OutOfBoundsException();
        if(isset($offset))
            $loc_offset = $offset;
        if(isset($limit))
            $loc_limit = $limit;
        
        $table = $this->getDbTable();
        $query = $table->select()
                   ->where('account = :id' )
                   ->order('done DESC')
                   ->limit(intval($loc_limit),  intval($loc_offset))
                   ->bind(array('id'=>$id));
        $rows = $table->fetchAll($query);                

        foreach ($rows as $row) {
            $entry = new Application_Model_Transaction();
            $entry->setId($row->transaction_id)
                ->setAccount($row->account)
                ->setTarget($row->target)
                ->setReference($row->reference)				  
                ->setAmount($row->amount)
                ->setDescription($row->description)
                ->setDone($row->done);
            $entries[] = $entry;
        }
        return $entries;            
    }

    public function createTransaction($accountId, $target, $reference, $amount, $description){
        $db = Zend_Db_Table::getDefaultAdapter();        
        try{
            $db->beginTransaction();            
            $account = new Application_Model_AccountMapper();            
            $account->updateAccount($accountId, $amount);
            $table = $this->getDbTable();    
            $data = array('account' => $accountId,
                    'target' => $target,
                    'reference' => $reference,
                    'amount' => $amount,
                    'description' => $description);
            $table->insert($data);
            $db->commit();                        
        } catch (Exception $e) {
            $db->rollBack();                    
            throw $e;
        }
    }
}

