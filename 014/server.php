<?php
require_once 'lib/Workerman/Autoloader.php';
require_once 'config.php';

use Workerman\Worker;

function handle_connect($connection)
{
    global $worker;

    $connection->uid = get_uid();

    $key = 'uid_' . $connection->uid;
    $val = array();

    set_config($key, $val);
}

function handle_message($connection, $data)
{
    $dataObj = json_decode($data);

    if(!is_null($dataObj) && isset($dataObj->action)) {
        if(!doAction($connection, $dataObj)) {
            $dataObj = ['action' => 'show_msg', 'msg' => "Action : ".$dataObj->action."执行失败"];
            send_msg($connection, $dataObj, true);
        } else {
            $dataObj = ['action' => 'show_msg', 'msg' => "Action : ".$dataObj->action."执行成功"];
            send_msg($connection, $dataObj, true);
        }
    } else {
        $data = array();
        $data['action'] = 'show_msg';
        if(!isset($dataObj->msg)) {
            $data['msg'] = json_encode($data);
        } else {
            $data['msg'] = $dataObj->msg;
        }

        send_msg($connection, $dataObj);
    }

}

/**
 * @param $connection
 * @param $data
 * @param bool $back 是否返回消息
 * @return mixed
 */
function send_msg($connection, $data, $back=false)
{
    if($back) {
        $connection->send(json_encode($data));
        return;
    }

    global $worker;

    $key = 'uid_' . $connection->uid;
    $config = get_config($key);

    if(empty($config)) {
        $data = ['action' => 'show_msg', 'msg' =>'未连接任何客户端'];

        return $connection->send(json_encode($data));
    }

    foreach($worker->connections as $con) {
        if(is_array($config) && !in_array($con->uid, $config) ) {
            continue;
        }

        if(!is_array($config) && $config != $con->uid) {
            continue;
        }

        $con->send(json_encode($data));
    }

    return true;
}

function doAction($connection, $dataObj)
{
    $dir = $dataObj->dir;
    if($dir != 'server') {
        send_msg($connection, $dataObj);
        return true;
    }

    $action = $dataObj->action;

    if(!function_exists($action)) {
        return false;
    }

    if(!$action($connection, $dataObj)){
        return false;
    }

    return true;
}

function bind_send_to_receive($connection, $dataObj)
{
    $receive_uid = $dataObj->receive_uid;
    $receive_key = 'uid_' . $receive_uid;
    $send_uid = $connection->uid;
    $send_key = 'uid_' . $send_uid;
    $send_config = get_config($send_key);
    $send_config[] = $receive_uid;
    $receive_config = get_config($receive_key);
    $receive_config[] = $send_uid;


    set_config($send_key, $send_config);
    set_config($receive_key, $receive_config);

    $data = ['action' => 'show_msg', 'msg' => "sendClient[$send_uid] : connect to you"];
    send_msg($connection, $data);

    return true;
}

//断开客户端绑定
function unbind($connection)
{
    $config = config::getInstance();
    $old_config = $config->getProperty('uid_' . $connection->uid);

    foreach($old_config as $val) {
        $key = 'uid_' . $val;
        $old_client_config = $config->getProperty($key);
        $new_client_config = array_diff($old_client_config, [$connection->uid]);
        $config->setProperty($key, $new_client_config);
    }

    $config->setProperty('uid_' . $connection, array());
}

function handle_close($connection)
{

    global $worker;
    foreach($worker->connections as $con) {
        $data = ['action' => 'show_msg', 'msg' => "user[{$connection->uid}] logout"];
        $con->send(json_encode($data));
    }
}

function get_connection_uid($connection, $dataObj)
{
    $uid = $connection->uid;
    $dataObj = ["action" => "show_connection_uid", "uid" => $uid];
    send_msg($connection, $dataObj, true);

    return true;
}

function get_connection_qid($connection, $dataObj)
{
    $qid = get_qid();
    $dataObj = ["action" => "show_qid", "qid" => $qid];
    send_msg($connection, $dataObj, true);

    return true;
}

//方位
function show_orientation($connection, $dataObj)
{
    send_msg($connection ,$dataObj);

    return true;
}

function get_ip()
{
    return get_config('ip');
}

function get_config($key)
{
    $config = config::getInstance();

    return $config->getProperty($key);
}

function get_uid()//获取全局唯一uid
{
    $config = config::getInstance();

    return $config->getUid();
}

function get_qid()
{
    $config = config::getInstance();

    return $config->getQid();
}

function set_config($key, $val)
{
    $config = config::getInstance();

    $config->setProperty($key, $val);
}

function is_set_property($key)
{
    $config = config::getInstance();

    return $config->isSetProperty($key);
}



$ip = get_ip();

$worker = new Worker("websocket://{$ip}:2345");

$worker->count = 1;

$worker->onConnect = 'handle_connect';

$worker->onMessage = 'handle_message';

$worker->onClose = 'handle_close';

Worker::runAll();