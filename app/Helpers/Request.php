<?php

namespace App\Helpers;

class Request {

    /**
     * Used primarily if you don't want your querystring to be encoded
     * @param array $variables
     * @return string
     */
    public static function urlencode(array $variables) {
        $result = '';
        foreach ($variables as $key => $value) {
            $result .= $key . '=' . $value . '&';
        }
        $result = trim($result, '&');
        return $result;
    }

}