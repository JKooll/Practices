<?php
require_once 'lib/phpqrcode/phpqrcode.php';
require_once 'config.php';

$props = array();

if(isset($_GET['props'])) {
    $props = json_decode($_GET['props'], true);
}

$getqrcode = new GetQrcode();
$getqrcode->url($props);


class GetQrcode
{

    public function url($props)
    {
        $config = config::getInstance();

        $url_root = $config->getProperty('url_root');

        if(substr($url_root, strlen($url_root) - 1, 1) != '/') {
            $url_root .= '/';
        }

        $url = $url_root;

        $count = 0;
        foreach($props as $key => $val) {
            $count++;

            if($key == "path") {
                $url .= $val;
                continue;
            }

            if($count == 2) {
                $url .= '?' . $key . '=' . $val;
                continue;
            }

            $url .= '&' . $key . '=' . $val;
        }
        $this->png($url);
    }

    private function png($msg)
    {
        //header("Content-Type : image/png");

        QRcode::png($msg);
    }

}