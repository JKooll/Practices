<?php
include_once "vendor/autoload.php";

use Medoo\Medoo;

class MyDB
{
    private static $dbtype = 'mysql';
    private static $host = 'localhost';
    private static $charset = 'utf8';

    public static function connection($username, $password, $database_name)
    {
        return new Medoo([
            'database_type' => self::$dbtype,
            'database_name' => $database_name,
            'server' => self::$host,
            'username' => $username,
            'password' => $password,
            'charset' => self::$charset,
        ]);
    }

    public static function createTable($medoo, $query)
    {
        return $medoo->query($query);
    }
}
