<?php

class Application_Model_Account
{
    public $_id; 
    public $_balance;
    public $_user;
    
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid user property');
        }
        $this->$method($value);
    }
    
    
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid user property');
        }
        return $this->$method();
    }
 
    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
    
    public function setId($id)
    {
        $this->_id = (int) $id;
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
                       'balance' => $this->_balance );        
        
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
                ->setBalance($resultset->balance);
        
        return $account;
    }
    
}

