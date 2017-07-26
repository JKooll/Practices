<?php
/**
 * Created by PhpStorm.
 * User: ZSQ
 * Date: 2016/9/12
 * Time: 9:30
 */
require_once ('SCS.php');
require_once ('config.php');

class listHandle
{
    //$flag和$titles中的key对应
    private $flag;
    private $origin = 'http://sinacloud.net/';
    private $bucket = 'yasi-001';
    private $titles = [
        0 => [
            'title' => '你的访问出错了',
            'path' => '001',
        ],

        1 => [
            'title' => '课文讲解',
            'path' => '002/',
            'type' => 'video'

        ],
        2 => ['title' => '歌曲演唱',
            'path' => '003/',
            'type' => 'video'
        ],
        3 => ['title' => '原创广告',
            'path' => '004/',
            'type' => 'video'
        ],
        4 => ['title' => '戏曲表演',
            'path' => '005/',
            'type' => 'video'
        ],
        5 => ['title' =>'微课堂',
            'path' => '007/',
            'type' => 'powerpoint'
        ],
        6 => ['title' => 'PPT资源',
            'path' => '006/',
            'type' => 'powerpoint'
        ]
    ];

    function __construct($flag)
    {
        $this->setFlag($flag);
    }

    function isVideo()
    {
        if($this->titles[$this->flag]['type'] != 'video'){
            return false;
        }

        return true;
    }

    function getList()
    {
        $path = $this->getPath();
        $bucket = $this->getBucket();

        $list = $this->doGetList($bucket, $path);

        return $list;
    }

    function getTitle()
    {
        return $this->titles[$this->flag]['title'];
    }

    function getPath()
    {
        return $this->titles[$this->flag]['path'];
    }

    function getBucket()
    {
        return $this->bucket;
    }

    function getOrigin()
    {
        return $this->origin;
    }

    function setFlag($flag)
    {
        if(!$this->isFlag($flag)){
            $this->flag = 0;
        }

        $this->flag = $flag;
    }

    function isFlag($flag)
    {
        if(!isset($this->titles[$flag])){
            return false;
        }

        return true;
    }

    function doGetList($bucket,$path)
    {
        $con = $this->connetcSCS();
        $result = $con::getBucket($bucket, $path);

        $list = [];
        foreach($result as $key => $val){
            if($key == $path){
                continue;
            }

            $path = $val['name'];

            $name = substr($val['name'], strpos($val['name'], '/') + 1);

            $url = $this->getOrigin().$bucket.'/'.$path;

            $list[] = ['url' => $url, 'name' => $name];
        }

        return $list;
    }

    function connetcSCS()
    {
        $scs_config = $this->getConfig('scs');
        $scs = new SCS($scs_config['AccessKey'], $scs_config['SecretKey']);
        return $scs;
    }

    function getConfig($config)
    {
        return config::getConfig($config);
    }
}