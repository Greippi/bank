<?php

class KSoft_TransactionResponse
{
    public $status;

    public $transactions;

    function __construct($status = KSoft_ErrorCodes::HTTP_OK, $transactions = array()) {
       $this->status = $status;
       $this->transactions = $transactions;
    }
    
    public function toArray() {
        return array('status'=>$this->status, 
                     'info'=> KSoft_ErrorCodes::message($this->status), 
                     'transactions' => $this->transactions);
    }      
}

