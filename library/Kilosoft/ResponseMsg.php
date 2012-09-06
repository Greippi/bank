<?php

class Kilosoft_ResponseMsg
{
    public $status;
    public $info;
    function __construct() {
        $this->status = Kilosoft_ErrorCodes::HTTP_OK;
        $this->info = '';
    }
}

