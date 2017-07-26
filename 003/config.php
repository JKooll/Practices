<?php
/**
 * Created by PhpStorm.
 * User: ZSQ
 * Date: 2016/9/12
 * Time: 10:11
 */

class config
{
    private static $db_config = [];

    //SCS配置
    private static $scs_config = [
    'AccessKey' => '2g3ql91MubncrSBUxevg',
    'SecretKey' => '102cb06a7e71391dbf94a3c4fbd65186c5ae5c87'
    ];

    static function getConfig($config)
    {
        return self::${$config.'_config'};
    }
}