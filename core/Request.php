<?php

namespace Core;

class Request
{
    public static function get($url, $ua = 'crawler')
    {
        $options = [
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "utf8",   // handle all encodings
            CURLOPT_USERAGENT      => $ua,      // user agent
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
            CURLOPT_SSL_VERIFYPEER => false     // Disabled SSL Cert checks
        ];
    
        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_errno($ch);
        $errmsg = curl_error($ch);
        $header = curl_getinfo($ch);
        $ip = curl_getinfo($ch, CURLINFO_PRIMARY_IP);
        curl_close($ch);
    
        return [
            'ip' => $ip,
            'http_code' => $http_code,
            'errno' => $err,
            'errmsg' => $errmsg,
            'header' => $header,
            'response' => $response,
        ];
    }

    public static function post($url, $data, $ua = 'crawler')
    {
        $options = [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $data,
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "utf8",   // handle all encodings
            CURLOPT_USERAGENT      => $ua,      // user agent
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
            CURLOPT_SSL_VERIFYPEER => false     // Disabled SSL Cert checks
        ];
    
        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_errno($ch);
        $errmsg = curl_error($ch);
        $header = curl_getinfo($ch);
        $ip = curl_getinfo($ch, CURLINFO_PRIMARY_IP);
        curl_close($ch);
    
        return [
            'ip' => $ip,
            'http_code' => $http_code,
            'errno' => $err,
            'errmsg' => $errmsg,
            'header' => $header,
            'response' => $response,
        ];
    }
}
