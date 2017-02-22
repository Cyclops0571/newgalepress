<?php


namespace App\Library;


class MyResponse
{
    function __construct()
    {
    }

    /**
     * @param string $msg
     * @return string
     */
    public function success($msg = '') {
        if(empty($msg)) {
            return 'success=true';
        } else if(starts_with($msg, '&')) {
            return 'success=true' . $msg;
        }
        return "success=true&msg=" . $msg;
    }

    /**
     * @param string $msg
     * @return string
     */
    public function error($msg = '') {
        if(empty($msg)) {
            return 'success=false';
        } else if(starts_with($msg, '&')) {
            return 'success=false' . $msg;
        }
        return "success=false&errmsg=" . $msg;
    }
}