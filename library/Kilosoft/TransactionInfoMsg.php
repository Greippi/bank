<?php

class Kilosoft_TransactionInfoMsg
{
    public $status;
    public $transactions;
    
   function __construct() {
       $this->status = 500;
       $this->transactions = array();
   }
}

