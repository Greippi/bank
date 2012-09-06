<?php

class Kilosoft_AccountInfoMsg
{
    public $status;
    public $id; 
    public $balance;
    public $owner;
    
   function __construct() {
       $this->status = Kilosoft_ErrorCodes::HTTP_OK;
       $this->id = -1;
       $this->balance = 0;
       $this->owner = '';
   }
    
}

