<?php

class KSoft_ResponseMsg
{
    public $status;
    public $info;
        
    function __construct($status = KSoft_ErrorCodes::HTTP_OK, 
                         $info ='') {
        
        $this->status = $status;
        $this->info = $info;
    }
    
    
}

