<?php
include "vendor/autoload.php";

class CreateTable
{
    private static $create_yueke_table =  "
        CREATE TABLE IF NOT EXISTS yueke (
            id INT PRIMARY KEY AUTO_INCREMENT,
            username VARCHAR(50),
            unit_code VARCHAR(50),
            course_item VARCHAR(200),
            start_time VARCHAR(20),
            end_time VARCHAR(20)
        )CHARACTER SET utf8;";

    private static $create_users_table = "
        CREATE TABLE IF NOT EXISTS users (
            id INT PRIMARY KEY AUTO_INCREMENT,
            username VARCHAR(50),
            password VARCHAR(50),
            last_access VARCHAR(50)
        )CHARACTER SET utf8;";

    private static $create_units_table = "
            CREATE TABLE IF NOT EXISTS units (
                id INT PRIMARY KEY AUTO_INCREMENT,
                name VARCHAR(50),
                code VARCHAR(50),
                place VARCHAR(50)
            )CHARACTER SET utf8;
        ";

    public static function create($db, $table = '')
    {
        if (empty($table)) {
            $db->query(self::$create_yueke_table);
            $db->query(self::$create_users_table);
            $db->query(self::$create_units_table);
            return;
        }
        if (isset(self::$table)) {
            $db->query(self::$table);
        }
    }
}
