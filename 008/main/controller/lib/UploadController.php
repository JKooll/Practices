<?php

/**
 * Created by PhpStorm.
 * User: ZSQ
 * Date: 2016/8/22
 * Time: 13:45
 */
class UploadController
{
    private $bucket = 'yasi-001';
    private $path = '';
    private $action = '';
    function __construct()
    {
        $this->run();
    }

    function run()
    {
        echo $this->resolve();
    }

    function getParam( $param )
    {
        if( isset( $this->{ $param } ) ){
            if( !empty( $this->{ $param } ) ){
                return $this->{ $param };
            }else{
                if( isset( $_GET[ $param ] ) ){
                    $this->{ $param } = $_GET[ $param ];
                    return $this->{ $param };
                }else{
                    return '';
                }
            }
        }else{
            return FALSE;
        }
    }

    function resolve()
    {
        $action = $this->getParam( 'action' );
        switch ( $action ){
            case 'getuploadurl' :
                return $this->getUploadUrl();
                break;
            case 'getparams' :
                $path = $this->getParam( 'path' );
                return $this->getSCSParams($path);
                break;
            default:
                return '';
                break;
        }
    }

    function getSCSParams( $path )
    {
        if( empty( $path) ){
            $this->setPath( $path );
        }

        date_default_timezone_set('UTC');

        // SCS access info
        if (!defined('AccessKey')) define('AccessKey', '2g3ql91MubncrSBUxevg');
        if (!defined('SecretKey')) define('SecretKey', '102cb06a7e71391dbf94a3c4fbd65186c5ae5c87');
        if (!defined('BucketName')) define('BucketName', 'yasi-001');

        // Check for CURL
        if (!extension_loaded('curl') && !@dl(PHP_SHLIB_SUFFIX == 'so' ? 'curl.so' : 'php_curl.dll'))
            exit("\nERROR: CURL extension not loaded\n\n");

        // Pointless without your keys!
        if (AccessKey == 'change-this' || SecretKey == 'change-this')
            exit("\nERROR: SCS access information required\n\nPlease edit the following lines in this file:\n\n".
                "define('AccessKey', 'change-me');\ndefine('SecretKey', 'change-me');\n\n");

        // Pointless without your BucketName!
        if (BucketName == 'change-this')
            exit("\nERROR: BucketName required\n\nPlease edit the following lines in this file:\n\n".
                "define('BucketName', 'change-me');\n\n");


        SCS::setAuth(AccessKey, SecretKey);

        $bucket = $this->bucket;
        $path = $this->path; // Can be empty ''

        $lifetime = 3600; // Period for which the parameters are valid
        $maxFileSize = (1024 * 1024 * 50); // 50 MB

        $metaHeaders = array('uid' => 123);
        $requestHeaders = array(
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename=${filename}'
        );

        $redirectPath = 'http://115.28.153.111:8080/ecing/main/view/page/upload.html';
        $params = SCS::getHttpUploadPostParams(
            $bucket,
            $path,
            SCS::ACL_PUBLIC_READ,
            $lifetime,
            $maxFileSize,
            $redirectPath, // Or a URL to redirect to on success
            $metaHeaders,
            $requestHeaders,
            false // False since we're not using flash
        );

        $result = array();
        $i = 0;
        foreach( $params as $key => $val){
            $result[ $i ] = array( 'key' => $key , 'val' => $val );
            $i++;
        }
        return json_encode( $result );
    }

    function getUploadUrl()
    {
        $uploadURL = 'http://' . $this->bucket . '.sinacloud.net/';
        return $uploadURL;
    }

    function setPath( $path ){
        $this->path = $path;
    }
}