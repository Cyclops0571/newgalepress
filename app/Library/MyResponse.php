<?php


namespace App\Library;


class MyResponse
{
    /**
     * @param string|array $msg
     * @return string
     */
    public function success($msg = '') {
        if(empty($msg)) {
            return 'success=true';
        } elseif (is_array($msg)) {
          $msg['success'] = 'true';
          return http_build_query($msg);
        }else if(starts_with($msg, '&')) {
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
        } elseif (is_array($msg)) {
            $msg['success'] = 'false';
            return http_build_query($msg);
        } else if(starts_with($msg, '&')) {
            return 'success=false' . $msg;
        }
        return "success=false&errmsg=" . $msg;
    }


}