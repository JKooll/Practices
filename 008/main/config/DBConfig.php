<?php
/**
 * Created by PhpStorm.
 * User: ZSQ
 * Date: 2016/7/23
 * Time: 15:37
 */
class DBConfig
{
    private $db_hostname = 'localhost';
    private $port = 3306;
    private $db_username = 'root';
    private $db_password = 'nishisheI12580';
    private $db_database = 'wechat';

    function getDBConfig()
    {
        $config = array( ' db_hostname ' => $this->db_hostname , ' db_database ' => $this->db_database ,
            ' db_username ' => $this->db_username , ' db_password ' => $this->db_password , 'port' => $this->port);
        return $config;
    }

    function getDBHostname()
    {
        return $this->db_hostname;
    }

    function getDBUsername()
    {
        return $this->db_username;
    }

    function getDBPassword()
    {
        return $this->db_password;
    }

    function getDBDatabase()
    {
        return $this->db_database;
    }
}

