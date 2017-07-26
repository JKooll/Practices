<?php
class Main
{
    private $wechat;
    private $tokenaccesskey = 'wxaa1bf0abbe69181c';
    private $encodingaeskey = '4cb8c76d2ca1cc889fb5e88b30cc883e';

    function __construct()
    {
        $options = array(
        		'token' => $this->tokenaccesskey, //填写你设定的key
                'encodingaeskey' => $this->encodingaeskey //填写加密用的EncodingAESKey，如接口为明文模式可忽略
        	);
        $wechat = new Wechat($options);
        $this->wechat = $wechat;

        if(!isset($_GET['echostr'] ) ){
            $wechat->getRev();
            $this->run($wechat);
        }else{
            $wechat->valid();
        }
    }

    private function run($wechat)
    {

    }
}
