<?php

namespace App;

class Helper
{
    public static function response($status, $mess, $data){
        if($status){
            return [
                'status' => true,
                'message' => $mess,
                'data' => $data,
            ];
        }
        return [
            'status' => false,
            'message' => $mess,
            'data' => $data,
        ];
    }
}
