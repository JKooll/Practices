<?php

/**
 * Created by PhpStorm.
 * User: ZSQ
 * Date: 2016/8/22
 * Time: 11:33
 */
class GetRemoteFilesController
{
    private $bucket = '';
    private $prefix = '';
    private $accessKey = '2g3ql91MubncrSBUxevg';
    private $secreKey  = '102cb06a7e71391dbf94a3c4fbd65186c5ae5c87';

    function getFile($prefix_name , $bucket = 'yasi-001')
    {
        if( empty( $this->prefix ) ){
            $this->setPrefix( $prefix_name );
        }

        date_default_timezone_set('UTC');
        // Check for CURL
        if (!extension_loaded('curl') && !@dl(PHP_SHLIB_SUFFIX == 'so' ? 'curl.so' : 'php_curl.dll'))
            exit("\nERROR: CURL extension not loaded\n\n");

        $scs = new SCS($this->accessKey, $this->secreKey);


        $pptList = $scs->getBucket( $bucket , $this->prefix );
        $result = array();
        $i = -1;
        foreach ( $pptList as $val){
            if( $i < 0 ) {
                $i ++;
                continue;
            }
            $path = '/'.$val['name'];
            $name = substr( $val['name'] , strpos( $val['name'] , '/' ) + 1 );
            $result[ $i ] = array( 'path' => $path, 'name' => $name );
            $i++;
        }

        return $result;

    }

    /**
     * @param string $prefix_name
     */
    public function setPrefix($prefix_name)
    {
        switch ( $prefix_name ){
            case 'ppt': $prefix = '006/'; break;
            case 'weike': $prefix = '007/';break;
            case 'kewen': $prefix = '002/';break;
            case 'music': $prefix = '003/';break;
            case 'ad': $prefix = '004/';break;
            case 'opera': $prefix = '005/';break;
            default : $prefix = '';
        }
        $this->prefix = $prefix;
    }
}