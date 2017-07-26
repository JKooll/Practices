<?php

class Handle
{
    //所有连接
    static public $connections = array();
    //当前连接
    private $connection = null;
    //绑定列表
    static public $binded = array();
    //数据
    private $data = array();
    //config
    private $config = array();

    public function __construct()
    {
        $this->config = include(dirname(__FILE__) . DIRECTORY_SEPARATOR . "config.php");
    }

    public function setData($data)
    {
        return $this->data = $data;
    }

    public function setConnection($connection)
    {
        return $this->connection = $connection;
    }

    public function delConnection($connection)
    {
        return array_splice(self::$connections, $connection->id);
    }

    public function run()
    {
        if(isset($this->data['action'])) {
            return $this->handleAction($this->data['action']);
        }

        return $this->connection->send(json_encode($this->data));
    }

    private function handleAction($action)
    {
        if(!method_exists($this, $action)) {
            return false;
        }

        return $this->$action();
    }

    /*
     * handle actions
     */

    private function sendMessage()
    {
        $receiver_connection = self::$connections[self::$binded[$this->connection->id]];

        echo $receiver_connection->id;

        $this->connection->send(json_encode(['content' => '发送成功']));

        $receiver_connection->send(json_encode($this->data));
    }

    private function bind()
    {
        if($this->connection == null) {
            return $this->connection->send(json_encode(["content" => "绑定失败, 请刷新重试"]));
        }

        $room_id = $this->data['room_id'];

        if(!isset(self::$connections[$room_id])) {
            return $this->connection->send(json_encode(["content" => "绑定失败，请刷新重试"]));
        }

        self::$binded[$this->connection->id] = $room_id;

        $result = ["content" => "绑定成功"];

        return $this->connection->send(json_encode($result));
    }

    private function getqrcode()
    {
        $room_id = $this->connection->id;

        $request_url = $this->data['url'];

        $explode_uri = explode('/', trim($request_url, '/'));

        array_splice($explode_uri, count($explode_uri) - 2);

        $explode_uri[count($explode_uri) - 1] = 'qrcode.php?room_id=' . $room_id;

        $src = implode('/', $explode_uri);

        $result = ['type' => 'qrcode', 'src' => $src];

        return $this->connection->send(json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK));
    }
}