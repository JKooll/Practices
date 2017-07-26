<?php
class CurlController
{
    function post( $url , $date )
    {
        $ch = curl_init();
        curl_setopt( $ch , CURLOPT_URL , $url );
        curl_setopt( $ch , CURLOPT_RETURNTRANSFER , 1 );
        curl_setopt( $ch , CURLOPT_PORT , 1);
        curl_setopt( $ch , CURLOPT_POSTFIELDS , $date);
        curl_setopt( $ch , CURLOPT_HEADER , 0 );
        $output = curl_exec( $ch );
        curl_close( $ch );
        return $output;
    }

    function get( $url = '')
    {
        echo $url;
        exit();
        $ch = curl_init();
        curl_setopt( $ch , CURLOPT_URL , $url );
        curl_setopt( $ch , CURLOPT_RETURNTRANSFER , 1 );
        curl_setopt( $ch , CURLOPT_HEADER , 0 );
        $output = curl_exec( $ch );
        curl_close( $ch );
        return $output;
    }
}
