<?php
/*
#路由消息
*/
class Route
{
    private $msg_type;
    private $wechat;

    function __construct($wechat, $msg_type)
    {
        $this->wechat = $wechat;
        $this->msg_type = $msg_type;
        $this->route_msg();
    }

    private function route_msg()
    {
        switch ($this->msg_type) {
            case Wechat::MSGTYPE_TEXT:
                break;
            case Wechat::MSGTYPE_EVENT:
                break;
            case Wechat::MSGTYPE_IMAGE:
                break;
            case Wechat::MSGTYPE_LINK:
                break;
            case Wechat::MSGTYPE_NEWS:
                break;
            case Wechat::MSGTYPE_MUSIC:
                break;
            case Wechat::MSGTYPE_LOCATION:
                break;
            case Wechat::MSGTYPE_VOICE:
                break;
            case Wechat::MSGTYPE_VIDEO:
                break;
            default:
                $wechat->text('信息有误！')->reply();
                break;
        }
    }
}
