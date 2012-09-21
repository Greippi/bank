<?php
/**
 * User model
 * 
 * @property-read int $id id-number
 * @property string $firstname first name
 * @property string $lastname surname
 * @property string $loginname name that is used when user login to servie
 * @property string $passwordhash md5 hashed password
 * @property string $salt password salt
 */
class Application_Model_User
{
    
    /**
     * @var int 
     */
    protected $_id; 
    
    /**
     * @var string
     * @length(0,20)
     */
    protected $_firstname;
    
    /**
     * @var string
     * @length(0,20) 
     */
    protected $_lastname;    
    
    /**
     * @var string
     * @length(0,20) 
     */
    protected $_loginname;
    
    /**
     * @var string
     */
    protected $_passwordhash;
    
    /**
     * @var string
     */
    protected $_passwordsalt;
    
    /**
     * @var int 
     */
    protected $_account;
   
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid user property: ' . $name . ' value ' . $value);
        }
        $this->$method($value);
    }    
    
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid user property: ' . $name );
        }
        return $this->$method();
    }
     
    public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }
    
    public function getID() {
        return $this->_id;
    }
    
    public function setFirstName($name) {
        $this->_firstname = $name;
        return $this;
    }
    
    public function setLastName($name) {
        $this->_lastname = $name;
        return $this;
    }
    
    public function setAccount(Application_Model_Account $accountID) {
        $this->_accountID = $accountID;
        return $this;
    }
      
    public function setLoginName($loginname) {
        $this->_loginname = $loginname;
        return $this;
    }
    
    public function setPassword($password) {        
        $dispencer = new Ksoft_SaltDispencer();        
        $this->_passwordsalt = $dispencer->salt(10);                        
        $this->_passwordhash = md5($password . $this->_passwordsalt);
    }
    
    public function getFirstName() {
        return $this->_firstname;        
    }
    
    public function getLastName() {
        return $this->_lastname;        
    }
    
    public function getAccountID() {
        return $this->_accountID;
    }
    
    public function getLoginName() {
        return $this->_loginname;        
    }
        
    public function toArray() {
        $array = array('firstname' => $this->_firstname, 
                     'lastname' => $this->_lastname, 
                     'loginname' => $this->_loginname, 
                     'passwordhash' => $this->_passwordhash,
                     'passwordsalt' => $this->_passwordsalt,
                     'accountid' => $this->_accountID );
        
        if(!$array['passwordhash'] ) {//Revent password no be nulled
               unset($array['passwordhash']);
               unset($array['passwordsalt']);
        }
        
        return $array;
    }
    
    /**
     * Convert resultset to Application_Model_User object
     * @param type $resultSet
     * @return Application_Model_User
     */
    public static function toModel( $resultSet ) {
        
        if(!$resultSet) {
            return null;
        }
        
        $user = new Application_Model_User();
        
        $user->setId($resultSet->id)
             ->setFirstName($resultSet->firstname)
             ->setLastName($resultSet->lastname)
             ->setLoginName($resultSet->loginname);                      
        
        return $user;
    }
}

