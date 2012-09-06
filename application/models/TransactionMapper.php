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
    protected $_account;
    protected $_target;
    protected $_reference;
    protected $_amount;
    protected $_description;
    protected $_done;	
    
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
    
    public function fetchTransactionsById($id) {
        try{        
            $entries = NULL;                    
            $table = $this->getDbTable();
            $query = $table->select()
                       ->where('account = :id' )
                       ->order('done DESC')
                       ->limit(10,0)
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
        } catch (Exception $e) {
            error_log ('BANK::ERROR: '.$e, 0);            
            return NULL;
        }
    }

    public function createTransaction($account, $target, $reference, $amount, $description){
        $table = $this->getDbTable();    
        $data = array('account' => $account,
                'target' => $target,
                'reference' => $reference,
                'amount' => $amount,
                'description' => $description);
        $table->insert($data);
        return TRUE;            
    }
}

