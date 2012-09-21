<?php
class KSoft_AccountInfoMsg
{
    public $status;
    
    public $id; 
    
    public $userid;
    
    public $balance;
    
    function __construct($id, $userid, $balance, $status = KSoft_ErrorCodes::HTTP_OK) {       
       $this->id = $id;
       $this->userid = $userid;
       $this->balance = $balance;
       $this->status = $status;
    }    
}

