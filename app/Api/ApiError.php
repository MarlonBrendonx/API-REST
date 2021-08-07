<?php 

namespace App\API;

class ApiError{
    
    public static function errorMessage($message,$code,$status){

        return [
            
            'msg'    => $message,
            'code'   => $code,
            'status' => $status
        ];

    }

}
