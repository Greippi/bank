<?php

class KSoft_TransactionInfoMsg
{
    public $status;
    public $transactions;
    
   function __construct() {
       $this->status = KSoft_ErrorCodes::HTTP_OK;
       $this->transactions = array();
   }
}

