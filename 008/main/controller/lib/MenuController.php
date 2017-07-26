<?php
class Menu
{
    private $menu = array(
        "button" => array(
            0 => array(
                "name" => "TOOLS",
                "sub_button" => array(
                    0 => array(
                        "type" => "click",
                        "name" => "开始/结束练习",
                        "key" => "JK_test"
                    ),
                    1 => array(
                        "type" => "click",
                        "name" => "下一题",
                        "key" => "JK_next"
                    ),
                    2 => array(
                        "type" => "view",
                        "name" => "吐槽灌水",
                        "url" => "http://buluo.qq.com/mobile/barindex.html?_bid=128&_wv=1027&bid=256769"
                    )
                )
            ),
            1 => array(
                "name" => "DIY大餐",
                "sub_button" => array(
                    0 => array(
                        "type" => "click",
                        "name" => "课文讲解",
                        "key" => "JK_kewen"
                    ),
                    1 => array(
                        "type" => "click",
                        "name" => "歌曲演唱",
                        "key" => "JK_gequ"
                    ),
                    2 => array(
                        "type" => "click",
                        "name" => "原创广告",
                        "key" => "JK_guanggao"
                    ),
                    3 => array(
                        "type" => "click",
                        "name" => "戏剧表演",
                        "key" => "JK_xijv"
                    )
                )
            ),
            2 => array(
                "name" => "干货",
                "sun_button" => array(
                    0 => array(
                        "type" => "click",
                        "name" => "微课堂",
                        "key" => "JK_weike"
                    ),
                    1 => array(
                        "type" => "click",
                        "name" => "练习题",
                        "key" => "JK_lianxi"
                    ),
                    2 => array(
                        "type" => "view",
                        "name" => "4A教学平台",
                        "url" => "http://202.198.96.252/hep/hepCoursePortalAction.do?courseid=187"
                    ),
                    3 => array(
                        "type" => "click",
                        "name" => "PPT资源",
                        "key" => "JK_ppt"
                    )
                )
            )
        )
    );

    function __construct($wechat)
    {
        $this->wechat = $wechat;
    }

    function createMenu($menu = '')
    {
        if( empty( $menu ) ){
            $menu = $this->menu;
        }
        if( $this->wechat->createMenu($menu) ) {
            return true;
        }else {
            return false;
        }
    }

    function delMenu()
    {
        if($this->wechat->deleteMenu() ){
            return true;
        }else{
            return false;
        }
    }

    function getMenu()
    {
        $menu = $this->wechat->getMenu();
        if(!$menu){
            return false;
        }else{
            return $menu;
        }
    }
}
