<?php

include_once "./vendor/autoload.php";
include_once "./handle.php";

use Workerman\Worker;

// 创建一个使用websocket协议通讯
$config = include_once('./config.php');
$ip = $config['ip'];
$port = $config['port'];

$ws_worker = new Worker("websocket://" . $ip . ":" . $port);

// 启动4个进程对外提供服务
$ws_worker->count = 4;

//返回连接id
$ws_worker->onConnect = function($connection){
    $connection->send(json_encode(["content" => "connection id is :" . $connection->id]));
};

// 当收到客户端发来的数据后返回hello $data给客户端
$ws_worker->onMessage = function($connection, $data) use($ws_worker) {
    Handle::$connections = $ws_worker->connections;
    $data = json_decode($data, true);
    var_dump($data);
    $handle = new Handle();
    $handle->setConnection($connection);
    $handle->setData($data);
    $handle->run();
};

// 运行worker
Worker::runAll();