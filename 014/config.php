<?php
/**
 * Created by PhpStorm.
 * User: ZSQ
 * Date: 2016/9/15
 * Time: 16:24
 */

class config
{
    private $props = [
        "ip" => "115.28.153.111",
        "port" => 5555,
        "url_root" => "http://115.28.153.111:5555/websocket"
    ];
    private static $instance;
    private $qid = 0;//QRcode全局编号
    private $uid = 0;//连接进程全局编号

    private function __construct() { }

    public static function getInstance()
    {
        if(empty(self::$instance)) {
            self::$instance = new config();
        }

        return self::$instance;
    }

    public function setProperty($key, $val)
    {
        $this->props[$key] = $val;
    }

    public function getProperty($key)
    {
        return $this->props[$key];
    }

    public function isSetProperty($key)
    {
        return isset($this->props[$key]);
    }

    public function getUid()
    {
        return ++$this->uid;
    }

    public function getQid()
    {
        return ++$this->qid;
    }
}