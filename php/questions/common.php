<?php
include_once "vendor/autoload.php";

use Medoo\Medoo;

abstract class Common
{
    protected $request_method;
    protected $create_table = "";

    public function __construct()
    {
        $this->request_method = strtolower($_SERVER["REQUEST_METHOD"]);
    }

    abstract protected function get();
    abstract protected function post();
    abstract protected function error();

    protected function view($page, $data = [])
    {
        if (file_exists($page)) {
            require_once($page);
        } else {
            require("view/404.html");
        }
        return 0;
    }

    public function process()
    {
        switch (strtolower($this->request_method)) {
            case 'get':
                $this->get();
                break;

            case 'post':
                $this->post();
                break;

            default:
                $this->error();
                break;
            }
    }

    protected function db()
    {
        $db_name = ENV('DB_NAME');
        $db_username = ENV('DB_USERNAME');
        $db_password = ENV('DB_PASSWORD');
        $db_host = ENV('DB_HOST');
        $db_type = ENV('DB_TYPE');
        $db_charset = ENV('DB_CHARSET');

        $medoo = new Medoo([
            'database_type' => $db_type,
            'database_name' => $db_name,
            'server' => $db_host,
            'username' => $db_username,
            'password' => $db_password,
            'charset' => $db_charset,
        ]);

        return $medoo;
    }

    protected function createTable($create_table)
    {
        $db = $this->db();
        return $db->query($create_table);
    }
}
