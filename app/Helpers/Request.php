<?php

namespace App\Helpers;

class Request {

    public static function urlencode(array $variables) {
        $result = '';
        foreach ($variables as $key => $value) {
            $result .= $key . '=' . $value . '&';
        }
        $result = trim($result, '&');
        return $result;
    }

}