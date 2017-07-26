<?php
/**
 * Created by PhpStorm.
 * User: ZSQ
 * Date: 2016/8/3
 * Time: 22:11
 */

class DIYController
{
    const ORIGIN = 'http://sinacloud.net/yasi-001';
    private $diy_id = 0;//DIY类别
    private $id = 0;//资源id
    private $kewen = array();

    private $music = array();

    private $ad = array();

    private $opera = array();

    function __construct()
    {
        $this->run();
    }

    function run()
    {
        echo $this->resolve();
    }

    function resolve()
    {
        $diy_id = $this->getParam( "diy_id" );

        switch ( $diy_id ){
            case 'kewen':
                return $this->getKewen();
                break;
            case 'music':
                return $this->getMusic();
                break;
            case 'ad':
                return $this->getAd();
                break;
            case 'opera':
                return $this->getOpera();
                break;
            default :
                return '';
        }
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

    /**
     * @return array
     */
    public function getKewen()
    {
        $this->getFile( 'kewen' );
        return json_encode( $this->kewen );
    }

    /**
     * @return array
     */
    public function getMusic()
    {
        $this->getFile( 'music' );
        return json_encode( $this->music );
    }

    /**
     * @return array
     */
    public function getOpera()
    {
        $this->getFile( 'opera' );
        return json_encode( $this->opera );
    }

    /**
     * @return array
     */
    public function getAd()
    {
        $this->getFile( 'ad' );
        return json_encode( $this->ad );
    }

    public function getFile( $file_name )
    {
        $getfile = new GetRemoteFilesController();
        $this->{$file_name} = $getfile->getFile( $file_name );
    }
}