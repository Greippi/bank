<?php

class Kilosoft_TransactionInfoMsg
{
    public $status;
    public $transactions;
    
   function __construct() {
       $this->status = Kilosoft_ErrorCodes::HTTP_OK;
       $this->transactions = array();
   }
}

