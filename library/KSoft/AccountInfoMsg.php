<?php

class KSoft_AccountInfoMsg
{
    public $status;
    public $id; 
    public $balance;
    
   function __construct() {
       $this->status = KSoft_ErrorCodes::HTTP_OK;
       $this->id = -1;
       $this->balance = 0;
   }
    
}

