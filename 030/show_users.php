<?php
include_once "vendor/autoload.php";

class ShowUsers
{
    use Common;

    private $yueke_table = 'yueke';
    private $users_table = 'users';
    private $request_method = "";

    public function __construct()
    {
        $this->request_method = strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function process()
    {
        switch ($this->request_method) {
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

    private function get()
    {
        if (empty($_GET['course_item'])) {
            return $this->error();
        }
        $course_item = $_GET['course_item'];
        echo $course_item;
    }

    private function post()
    {

    }

    private function error()
    {
        echo "<h1>404</h1>";
    }

    private function view($page, $params = '')
    {
        $tag = $this->tag;
        if(!file_exists($page)) {
            return $this->error();
        }
        return require($page);
    }
}

$showusers = new ShowUsers();
$showusers->process();
