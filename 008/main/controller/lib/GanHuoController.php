<?php
/**
 * Created by PhpStorm.
 * User: ZSQ
 * Date: 2016/8/5
 * Time: 11:23
 */

class GanHuoController
{
    private $action = '';
    private $ppts = array();

    private $weike = array();

    function __construct()
    {
        echo $this->run();
    }

    function run()
    {
        return $this->resolve();
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
            case 'getppts' :
                return $this->getPpts();
                break;
            case 'getweike' :
                return $this->getWeike();
                break;
            default:
                return '';
            break;
        }
    }

    function getPpts()
    {
        $getFiles = new GetRemoteFilesController();
        $this->ppts =  $getFiles->getFile( 'ppt' );
        return json_encode( $getFiles->getFile( 'ppt' ));

    }

    function getWeike()
    {
        $getFiles = new GetRemoteFilesController();
        $this->weike =  $getFiles->getFile( 'weike' );
        return json_encode( $this->weike );
    }

}