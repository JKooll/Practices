<?php
class MyInclude
{
    private $files = array(
            'PagePath' => 'PagePath.php',
            //core
            'wechat' => 'core/wechat/wechat.class.php',
            'Router' => 'core/Router.php',
            //main
            'Main' => 'main/Main.php',
            'Route' => 'main/Route.php',
            //main/config
            'DBConfig' => 'main/config/DBConfig.php',
            //main/controller
            'EventController' => 'main/controller/EventController.php',
            'ImageController' => 'main/controller/ImageController.php',
            'LinkController' => 'main/controller/LinkController.php',
            'LocationController' => 'main/controller/LocationController.php',
            'MusicController'=> 'main/controller/MusicController.php',
            'NewsController' => 'main/controller/NewsController.php',
            'TextController' => 'main/controller/TextController.php',
            'VideoController' => 'main/controller/VideoController.php',
            'VoiceController' => 'main/controller/VoiceController.php',
            //controller/lib
            'TranslationController' => 'main/controller/lib/TranslationController.php',
            'ExeSysController' => 'main/controller/lib/ExeSysController.php',
            'MenuController' => 'main/controller/lib/MenuController.php',
            'CurlController' => 'main/controller/lib/CurlController.php',
            'DBController' => 'main/controller/lib/DBController.php',
            'DIYController' => 'main/controller/lib/DIYController.php',
            'GanHuoController' => 'main/controller/lib/GanHuoController.php',
            'SCS' => 'main/controller/lib/SCS.php',
            'SCSWrapper..php' => 'main/controller/lib/SCSWrapper.php',
            'GetRemoteFilesController' => 'main/controller/lib/GetRemoteFilesController.php',
            'UploadController' => 'main/controller/lib/UploadController.php',
            //test
            'test.class' => 'test/test.class.php'
        );

    function includeFile( $filename = '' )
    {
        if( !empty($filename) && array_key_exists( $filename , $this->files ))
            include_once $this->files[$filename];
    }

    function includeFiles( $filenames = array() )
    {
        foreach ($filenames as $filename) {
            $this->includeFile( $filename );
        }
    }

    function includeAllFile()
    {
        $filenames = array_keys($this->files);
        $this->includeFiles($filenames);
    }

    function includeOtherFile($needIncludefiles)
    {
        $tempFiles = array();
    }

    function getFilePath( $filename = '')
    {
        if( !empty( $filename ) ){
            return $this->files[$filename];
        }
        return $filename;
    }

}
