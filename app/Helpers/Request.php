<?php

namespace App\Helpers;

class Request {

    /**
     * Used primarily if you don't want your querystring to be encoded
     * @param array $variables
     * @return string
     */
    public static function urlencode(array $variables) {
        return http_build_query($variables);
    }

    public static function sendGetRequest(string $url, $options = []) {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

        foreach ($options as $option => $value) {
            curl_setopt($curl, $option, $value);
        }

        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }

}
