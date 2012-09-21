<?php

class Application_Model_Transaction
{
    protected $_id; 
    protected $_account;
    protected $_target;
    protected $_reference;
    protected $_amount;
    protected $_description;
    protected $_done;	
	
    
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
    
    public function setAccount($account) {
        $this->_account = $account;
        return $this;
    }
    
    public function setTarget($target) {
        $this->_target = $target;
        return $this;
    }

    public function setReference($reference) {
        $this->_reference = $reference;
        return $this;
    }
    
    public function setAmount($amount) {
        $this->_amount = $amount;
        return $this;
    }

    public function setDescription($description) {
        $this->_description = $description;
        return $this;
    }
    
    public function setDone($done) {
        $this->_done = $done;
        return $this;
    }
    
    public function getId() {
        return $this->_id;        
    }

    public function getAccount() {
        return $this->_account;
    }
    
    public function getTarget() {
        return $this->_target;
    }

    public function getReference() {
        return $this->_reference;
    }
    
    public function getAmount() {
        return $this->_amount;
    }

    public function getDescription() {
        return $this->_description;
    }
    
    public function getDone() {
        return $this->_done;
    }
    
    public function toArray() {
        $array = array('id' => $this->getId(),
                       'account' => $this->getAccount(),
                       'target' => $this->getTarget(),                
                       'reference' => $this->getReference(), 				  
                       'amount' => $this->getAmount(), 				                      
                       'description' => $this->getDescription(), 				                                          
                       'done' => $this->getDone()); 
        
        return $array;
    }
}

