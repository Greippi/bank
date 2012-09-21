<?php

/**
 * Description of Session
 */
class Application_Model_Session {
    
    protected $_user;
    
    protected $_sessionkey;
    
    protected $_valid;
    
    protected $_created;
        
    public function getUser() {
        return $this->_user;
    }

    public function getSessionkey() {
        return $this->_sessionkey;
    }

    public function getValid() {
        return $this->_valid;
    }

    public function getCreated() {
        return $this->_created;
    }

    public function setUser($user) {
        $this->_user = $user;
    }

    public function setSessionkey($sessionkey) {
        $this->_sessionkey = $sessionkey;
    }

    public function setValid($valid) {
        $this->_valid = $valid;
    }

    public function setCreated($created) {
        $this->_created = $created;
    }

        
        
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid session property: ' . $name . ' value ' . $value);
        }
        $this->$method($value);
    }       
    
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid session property: ' . $name );
        }
        return $this->$method();
    }
    
    public static function toModel($resultSet) {
        
        $session = new Application_Model_Session();
        
        $session->_sessionkey = $resultSet->sessionkey;
        $session->_created = $resultSet->created;
        $session->_valid = $resultSet->valid;
                
        return $session;        
    }
}

?>
