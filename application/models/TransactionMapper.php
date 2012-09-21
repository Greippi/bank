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

    /**
     * Fetch all account transactions
     * @param type $accountID
     * @return array<Application_Model_Transaction>
     */
    public function fetchAll($accountID) {
        
        $query = $this->getDbTable()
                      ->select()
                      ->where('account_id = :accountid')
                      ->order('done')
                      ->bind(array('accountid'=>$accountID));
                      
        
        $resultSet = $this->getDbTable()->fetchAll($query);
        
        $transactions   = array();
        
        foreach ($resultSet as $row) {
            $transaction = new Application_Model_Transaction();

            $transaction->setId($row->transaction_id)
                        ->setAccount($row->account_id)
                        ->setTarget($row->target_id)
                        ->setReference($row->reference)			
                        ->setAmount($row->amount)
                        ->setDescription($row->description)
                        ->setDone($row->done);
            
            $transactions[] = $transaction;
        }
        
        return $transactions;
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
                   ->where('account = :id or target = :id' )
                   ->order('done DESC')
                   ->limit(intval($loc_limit),  intval($loc_offset))
                   ->bind(array('id'=>$id));
        $rows = $table->fetchAll($query);                

        foreach ($rows as $row) {
            $entry = new Application_Model_Transaction();
            $entry->setId($row->transaction_id)
            ->setAccount($row->account)
            ->setTarget($row->target)
            ->setReference($row->reference);
            
            //if transferred to current account then show positive amount
            if($id == $row->target && $row->account != $row->target)
                $entry->setAmount(-$row->amount);
            else
                $entry->setAmount($row->amount);                
            $entry->setDescription($row->description);
            $entry->setDone($row->done);
            $entries[] = $entry;
        }
        return $entries;            
    }

    public function createTransaction(Application_Model_User $user, 
                                      $accountId, 
                                      $targetId, 
                                      $reference, 
                                      $amount, 
                                      $description){
        
        $db = Zend_Db_Table::getDefaultAdapter();        
        
        try{
            $db->beginTransaction();
            
            $accountMapper = new Application_Model_AccountMapper();
            
            $account = $accountMapper->fetchAccount($user, $accountId);
            
            if(!$account) {
                throw new Exception('Trying to access non existing account',
                                     KSoft_ErrorCodes::ERR_ACCOUNT_NOT_FOUND);
            }
            
            $account->balance += $amount;
            
            if($account->balance < 0) {
                throw new Exception('Insuffient balance', 
                                    KSoft_ErrorCodes::ERR_INSUFFICIENT_BALANCE );
            }
            
            $accountMapper->updateAccount($account);             
            $table = $this->getDbTable();    
            
            $data = array('account_id' => $accountId,
                        'target_id' => $targetId,
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

