<?php

namespace App\Library;

class AjaxResponse {

    private function __construct()
    {
        ;
    }

    public static function error($errorMsg)
    {
        $tmpArray = [
            "errmsg"  => (string)$errorMsg,
            "success" => false,
        ];

        return json_encode($tmpArray);
    }

    public static function success($msg = "")
    {
        $responseArray = ["success" => true];
        if (!empty($msg))
        {
            $responseArray["successMsg"] = (string)$msg;
        }

        return json_encode($responseArray);
    }
}
