<?php
/*
 * 依赖CurlController
 */
class TranslationController
{
    private $toBeTrans = "";
    private $curl = "";
    private $trans_method = "";
    const APPID_BAIDU = '20160122000009213';
    const SECRETKEY_BAIDU = 'mI5MJC_T5IsK9plXItWO';
    const KEYFROM_WANGYI = 'wechatecing';
    const KEY_WANGYI = '131704034';
    const DOCTYPE_WANGYI = 'json';
    //%s => q, %s => appid,%s => salt, %s => sign
    const URL_BAIDU = 'http://api.fanyi.baidu.com/api/trans/vip/translate?q=%s&from=auto&to=auto&appid=%s&salt=%s&sign=%s';
    //%s => keyfrom , %s => key , %s => doctype , %s => q
    const URL_WANGYI = 'http://fanyi.youdao.com/openapi.do?keyfrom=%s&key=%s&type=data&doctype=%s&version=1.1&q=%s';

    function __construct()
    {
        $this->curl = new CurlController();
        echo $this->run();
    }

    function run()
    {
        return $this->resolve();
    }

    function resolve()
    {
        $toBeTrans = $this->getParam( "toBeTrans" );
        $trans_method = $this->getParam( "trans_method" );

        return $this->translation( $toBeTrans , $trans_method );
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

    function translation( $toBeTrans , $trans_method = "baidu" )
    {
        $this->toBeTrans = $toBeTrans;

        $transResult = "";
        switch ($trans_method){
            case "baidu" :
                $transResult = $this->baiDu();
                break;
            case "wangyi" :
                $transResult = $this->wangYi();
                break;
            default :
                return $transResult;
        }
        return $transResult;
    }

    private function baiDu()
    {
        $url = $this->getUrlBaiDu();
        $transResult = $this->curl->get($url);
        $content = $transResult['trans_result'][0]['dst'];
        return $content;
    }

    private function getUrlBaiDu()
    {
        $q = $this->toBeTrans;
        $salt=rand(100000,1000000);
        $sign=self::APPID_BAIDU.$q.$salt.self::SECRETKEY_BAIDU;
        $sign=md5($sign);

        $q = urlencode( $q );
        $url = sprintf( self::URL_BAIDU , $q , self::APPID_BAIDU , $salt , $sign );

        return $url;
    }

    private function wangYi()
    {
        $url = $this->getUrlWanYi();
        $transResult = $this->curl->get( $url );
        $content = $transResult['translation'][0];
        return $content;
    }

    private function getUrlWanYi()
    {
        $q = urlencode( $this->toBeTrans );
        $url = sprintf( self::URL_WANGYI , self::KEYFROM_WANGYI , self::KEY_WANGYI , self::DOCTYPE_WANGYI , $q );
        return $url;
    }
}
