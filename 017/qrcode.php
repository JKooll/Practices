<?php
header('Content-type: image/png');

include_once "./vendor/autoload.php";

$config = include('config.php');

$public_ip = $config['public_ip'];

$room_id = $_REQUEST['room_id'];

$explode_uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

$explode_uri[count($explode_uri) - 1] = 'App/pages/device.php?room_id=' . $room_id;

$url = "http://" . $public_ip . '/' . implode('/', $explode_uri);

$renderer = new \BaconQrCode\Renderer\Image\Png();
$renderer->setHeight(256);
$renderer->setWidth(256);
$writer = new \BaconQrCode\Writer($renderer);
echo $writer->writeString($url);