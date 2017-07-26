<?php
include_once "vendor/autoload.php";

use Medoo\Medoo;

trait Common
{
    private function getUnits()
    {
        $units = [];
        $db = $this->db();
        $units = $db->select($this->units_table, "*");
        return $units; 
    }

    private function getClasses()
    {
        $classes_str = ENV('CLASSES');
        $classes_arr = explode('+', $classes_str);
        $classes_arr = array_filter($classes_arr, function($item) {
            if (empty($item)) {
                return false;
            }
            return true;
        });
        return $classes_arr;
    }

    private function getTag()
    {
        return ENV('TAG');
    }

    private function db()
    {
        $dbtype = ENV('DB_TYPE');
        $database_name = ENV('DB_NAME');
        $host = ENV('DB_HOST');
        $username = ENV('DB_USERNAME');
        $password = ENV('DB_PASSWORD');
        $charset = ENV('DB_CHARSET');

        return new Medoo([
            'database_type' => $dbtype,
            'database_name' => $database_name,
            'server' => $host,
            'username' => $username,
            'password' => $password,
            'charset' => $charset,
        ]);
    }

    private function login()
    {
        if (!$this->validate()) {
            http_response_code(401);
            header('WWW-Authenticate: Basic realm="约课系统"');
            echo "请输入正确的用户名和密码。";
            exit();
        }
    }
}
