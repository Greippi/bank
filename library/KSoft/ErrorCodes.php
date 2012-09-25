<?php

class KSoft_ErrorCodes {
    
    const HTTP_OK = 200;    
    const HTTP_NOT_IMPLEMENTED = 501;
    
    const AUTH_OK = 200;    
    const ERR_HTTP_FAIL = 400;  
        
    const ERR_INVALID_PARAMETERS = -1;
    const ERR_INVALID_ACCOUNT_ID_PARAM = -2;    
    const ERR_INVALID_AMOUNT_PARAM = -3;        
    const ERR_INVALID_ACTION_PARAM = -4;            
    const ERR_INSUFFICIENT_BALANCE = -5;                
    const ERR_DB_SAVE_FAILED = -6;                    
    const ERR_ACCOUNT_NOT_FOUND = -7;                        
    const ERR_AUTH_UNKNOWN = -8;
    const ERR_AUTH_EXPIRED = -9;
    const ERR_AUTH_UNKNOWN_ERROR = -10;    
    
    
    public static $info = null;
    
    private static function createInfoArray() {
        return array(KSoft_ErrorCodes::HTTP_OK => "Ok",
                    KSoft_ErrorCodes::HTTP_NOT_IMPLEMENTED => 'Action is not implemented',
                    KSoft_ErrorCodes::ERR_INVALID_PARAMETERS => 'Invalid parameters',
                    KSoft_ErrorCodes::ERR_INVALID_ACCOUNT_ID_PARAM =>'Invalid account id or user has no access to account.',
                    KSoft_ErrorCodes::ERR_INVALID_AMOUNT_PARAM => 'Ivalid amount of request parameters',
                    KSoft_ErrorCodes::ERR_INVALID_ACTION_PARAM => 'Action is not supported',
                    KSoft_ErrorCodes::ERR_INSUFFICIENT_BALANCE => 'Account balance exciited',
                    KSoft_ErrorCodes::ERR_DB_SAVE_FAILED => 'Could not insert or update data to database',
                    KSoft_ErrorCodes::ERR_ACCOUNT_NOT_FOUND => 'Acount not found',                    
                    KSoft_ErrorCodes::ERR_AUTH_EXPIRED => 'Authentication expired. Please renew authentication.',
                    KSoft_ErrorCodes::ERR_AUTH_UNKNOWN_ERROR => 'Authentication unknown error');
    }

    /**
     * Return error message for error code
     * 
     * @param int $errorCode
     * @return string
     */
    public static function message($errorCode) {               
        
        if(!isset(KSoft_ErrorCodes::$info)) {
            KSoft_ErrorCodes::$info = KSoft_ErrorCodes::createInfoArray();
        }                                
                                
        if(is_int($errorCode) && array_key_exists($errorCode, KSoft_ErrorCodes::$info)) {
            return KSoft_ErrorCodes::$info[$errorCode];
        } 
    }    
}

?>
