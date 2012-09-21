<?php
/**
 * UserMapper provides interface to access database
 * 
 * @property Zend_Db_Table_Abstract $_dbTable User table adapter
 */
class Application_Model_UserMapper
{
    protected $_dbTable;   

    /**
     * Set database table
     * @param type $dbTable
     * @return \Application_Model_UserMapper
     * @throws Exception
     */
    private function setDbTable($dbTable)
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
     * @return Application_Model_DbTable_Users
     */
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_User');
        }
        return $this->_dbTable;
    }
    
    public function get($id) {
        
        $table = $this->getDbTable();
        
        $query = $table->select()
               ->where('id = :id')
               ->bind(array('id'=>$id));
        
        $result = $table->fetchRow($query);
        
        return Application_Model_User::toModel($result);
    }
    
        
    public function getBySessionKey($sessionkey) {
        
        
        
        $table = $this->getDbTable();
        
        $query = $table->select()
               ->where('id = :id')
               ->bind(array('id'=>$id));
        
        $result = $table->fetchRow($query);
        
        return Application_Model_User::toModel($result);
    }
    
    /**
     * Update or save new user model to database. If user is created updates model
     * id number.
     * 
     * @param Application_Model_User $user
     */
    public function save(Application_Model_User $user)
    {               
        $table = $this->getDbTable();       
        
        if( $user->id ) {            
            $array = $user->toArray();                        
            
            $table->update($array, 'id =' . $user->id );
        } else {            
            $id = $table->insert($user->toArray());        
            $user->setId($id);
        }
    }
        
    /**
     * Fetch all user objects from database
     * @return array<Application_Model_User>
     */
    public function fetchAll() {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entries[] = $this->toModel($row);
        }
        return $entries;
    }
}

