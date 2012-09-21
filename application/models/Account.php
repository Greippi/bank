<?php
class Application_Model_Account extends KSoft_Model
{
    public $_id; 
    public $_balance;
    public $_user;
    public $_name;    
    
    public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }
    
    public function setName($name) {
        $this->_name = $name;
        return $this;
    }
    
    public function getName() {
        return $this;
    }
    
    public function setBalance($balance) {
        $this->_balance = $balance;
        return $this;
    }
    
    public function setUser(Application_Model_User $user){
        $this->_user = $user;
        return $this;
    }

    public function getUser() {
        return $this;
    }    

    public function getId() {
        return $this->_id;        
    }
    
    public function getBalance() {
        return $this->_balance;        
    }   
    
    public function toArray() {
        $array = array('id' => $this->id, 
                       'balance' => $this->_balance,
                       'name' => $this->_name );        
        
        if($this->_user) {
            $array['userid'] = $this->_user->id;
        }
        
        return $array;
    }
    
    public static function toModel($resultset) {
        
        if($resultset == null) {
            return null;
        }
        
        $account = new Application_Model_Account();
        
        $account->setId($resultset->account_id)
                ->setBalance($resultset->balance)
                ->setName($resultset->name);
        
        return $account;
    }
    
}

