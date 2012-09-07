<?php

class KSoft_ResponseMsg
{
    public $status;
    public $info;
    function __construct() {
        $this->status = KSoft_ErrorCodes::HTTP_OK;
        $this->info = '';
    }
}

