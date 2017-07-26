<?php
class CurlController
{
    public function post( $url , $date = array())
    {
        $ch = curl_init();
        curl_setopt( $ch , CURLOPT_URL , $url );
        curl_setopt( $ch , CURLOPT_RETURNTRANSFER , 1 );
        curl_setopt( $ch , CURLOPT_POST , 1);
        curl_setopt( $ch , CURLOPT_POSTFIELDS , $date);
        curl_setopt( $ch , CURLOPT_HEADER , 0);
    }

    public function get($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL , $url );
        curl_setopt( $ch ,  CURLOPT_RETURNTRANSFER , 1);
        curl_setopt( $ch , CURLOPT_HEADER , 0);
        $output = curl_exec($ch);
        curl_close($ch);
        if( !is_array( $output ) ){
            return json_decode( $output , true );
        }else{
            return $output;
        }
    }
}
