<?php
include_once "vendor/autoload.php";

use Medoo\Medoo;

class YueKeAdmin
{
    use common;

    private $request_method; //保存用户请求方式
    private $yueke_admin_login_page = 'yueke_admin_login_page.php';
    private $yueke_admin_page = "yueke_admin_page.php"; //约课主页面
    private $medoo; //保存数据库连接实例
    private $yueke_table = "yueke"; //保存约课记录
    private $users_table = "users"; //保存用户
    private $units_table = "units";
    private $weeks = ['mo' => 1, 'tu' => 2, 'we' => 3, 'th' => 4, 'fr' => 5]; //星期
    private $course_time = ['1_2' => 1, '3_4' => 2, '5_6' => 3, '7_8' => 4]; //上课时间

    public function __construct($request_method, $db_username, $db_password, $db_name)
    {
        $this->login();
        $this->request_method = $request_method;
        $this->medoo = $this->db();
        CreateTable::create($this->medoo);
    }

    public function process()
    {
        if (!empty($_REQUEST['get_choosed_result']) && $_REQUEST['get_choosed_result'] == "true") {
            return $this->getSingleUnitChoosed();
        }

        switch ($this->request_method) {
            case 'get':
                $this->get();
                break;

            case 'post':
                $this->post();
                break;

            default:
                $this->error(['error' => '请求出错']);
                break;
        }
    }

    private function get($params = [])
    {
        $params['has_choosed'] = [];
        $params['start_time'] = date('Y_m_d');
        $params['end_time'] = date('Y_m_d');
        $params['units'] = $this->getUnits();
        $params['units_str'] = ENV('UNITS');
        $params['classes'] = $this->getClasses();
        $params['tag'] = ENV('TAG');
        $params['managers'] = $this->getManagers();
        //渲染并返回页面
        return $this->view($this->yueke_admin_page, $params);
    }

    private function getSingleUnitChoosed()
    {
        $this->units = $this->getUnits();
        $start_time = str_replace('-', '_', $_REQUEST['start_time']);
        $end_time = str_replace('-', '_', $_REQUEST['end_time']);
        if ($start_time == "" || $end_time == "") {
            $start_time = date('Y_m_d');
            $end_time = date('Y_m_d');
        }
        $course_items = [];
        for ($k = 0; $k < count($this->units); $k++) {
            for ($i = 1; $i <= 4; $i ++) {
                for ($j = 1; $j <= 5; $j++) {
                    $course_item = '';
                    foreach ($this->weeks as $key => $val) {
                        if($val == $j) {
                            $course_item .= $key;
                        }
                    }
                    foreach ($this->course_time as $key => $val) {
                        if ($val == $i) {
                            $course_item .= '_' . $key;
                        }
                    }
                    $course_items[$this->units[$k]['code']][$i][$j] = ['is_has_choosed' => '', 'value' => $course_item, 'count' => 0, 'users' => ''];
                }
            }
        }

        //获取已选课程
        for($q = 0; $q < count($this->units); $q++) {
            $where = ['unit_code' => $this->units[$q]['code'],
                'start_time[<=]' => $end_time,
                'end_time[>=]' => $start_time
            ];
            $result_arr = $this->medoo->select(
                $this->yueke_table,
                ['username', 'course_item'],
                $where
            );
            foreach ($result_arr as $result_key => $result_val) {
                $result = $result_val;
                $course_items_arr = explode("&", $result['course_item']);
                foreach ($course_items_arr as $key => $val) {
                    if (empty($val)) {
                        continue;
                    }
                    $course_item_arr = explode('_', $val);
                    $course_item_obj = &$course_items[$this->units[$q]['code']][$this->course_time[$course_item_arr[1] . '_' . $course_item_arr[2]]][$this->weeks[$course_item_arr[0]]];
                    $count = $course_item_obj['count']+1;
                    $users = $course_item_obj['users'] . "{$result['username']}<br/>";
                    $course_item_obj = ['is_has_choosed' => 'true' , 'value' => $val, 'count' => $count, 'users' => $users];
                }
            }
        }

        $params['has_choosed'] = $course_items;
        $params['units'] = $this->getUnits();
        $params['managers'] = $this->getManagers();
        $params['start_time'] = $start_time;
        $params['end_time'] = $end_time;
        //渲染并返回页面
        return $this->view($this->yueke_admin_page, $params);
    }

    private function post()
    {
        $_POST['form_tag'] = isset($_POST['form_tag']) ? $_POST['form_tag'] : '';

        switch ($_POST['form_tag']) {
            case 'setting':
                $this->setting();
                break;

            case 'change_course_result':
                $this->changeCourse();
                break;

            case 'add_manager':
                return $this->addManager();
                break;

            default:
                return $this->get();
                break;
        }
    }

    private function setting()
    {
        //要设置的配置标签
        if (!isset($_POST['units'])) {
            $_POST['units'] = [];
        }
        $db = $this->medoo;
        $units = $_POST['units'];
        $db->delete($this->units_table, []);
        for ($i = 0; $i < count($units); $i++) {
            $unit = explode(':', $units[$i]);
            if (empty($unit[0]) || empty($unit[1])) {
                continue;
            }
            $unit_code = 'unit' . uniqid();
            $unit_name = $unit[0];
            $unit_place = $unit[1];
            $db->insert($this->units_table, [
                'code' => $unit_code,
                'name' => $unit_name,
                'place' => $unit_place
            ]);
        }
        return $this->success();
    }

    private function changeCourse()
    {

    }

    private function addManager()
    {
        $db = $this->db();
        $_POST['managers'] = isset($_POST['managers']) ? $_POST['managers'] : '';
        $manager_str = trim($_POST['managers'], '&');
        $manager_arr = explode('&', $manager_str);
        $db->delete($this->users_table, []);
        for ($i = 0; $i < count($manager_arr); $i++) {
            if (empty($manager_arr[$i])) {
                continue;
            }
            $user = explode('=', $manager_arr[$i]);
            $error_str = "";
            if ($db->has($this->users_table, ['username' => $user[0]])) {
                $error_str .= $user[0] . ",";
                continue;
            }
            $db->insert($this->users_table, ['username' => $user[0], 'password' => $user[1], 'last_access' => "-1"]);
        }
        if (!empty($error_str)) {
            return $this->get(['error' => "登录名{$error_str}已存在！！！"]);
        }
        return $this->success();
    }

    private function getManagers()
    {
        $db = $this->medoo;
        $managers = $db->select($this->users_table, ['username(manager_name)', 'password(manager_pwd)']);
        return $managers;
    }

    private function setClasses()
    {
        $classes_str = isset($_POST['classses']) ? $_POST['classes'] : '';
        return set_env('CLASSES', $classes_str);
    }

    private function getClasses()
    {
        $classes = ENV('CLASSES');
        $classes_arr = explode('+', $classes);
        $classes_arr = array_filter($classes_arr, function($item) {
            if (empty($item)) {
                return false;
            }
            return true;
        });
        return $classes_arr;
    }

    private function view($page, $params = [])
    {
        if(!file_exists($page)) {
            echo '<div style="margin-top:50px;text-align:center"><h1>404 Not Found! ^_^</h1></div>';
        }
        return require($page);
    }

    private function error($params = ['error' => '操作出错'])
    {
        return $this->get($params);
    }

    private function success($params = ['success' => '操作成功'])
    {
        return $this->get($params);
    }

    private function validate()
    {
        if (empty($_SERVER['PHP_AUTH_USER']) || empty($_SERVER['PHP_AUTH_PW'])) {
            return false;
        }
        $username = $_SERVER['PHP_AUTH_USER'];
        $password = $_SERVER['PHP_AUTH_PW'];
        $real_username = ENV('ROOT_NAME');
        $real_password = ENV('ROOT_PWD');
        if ($real_password !== $password || $real_username !== $username) {
            return false;
        }
        $now = time();
        if ($now - ENV('ROOT_LAST_ACCESS') > 60) {
            set_env('ROOT_LAST_ACCESS', $now);
            return false;
        }
        return true;
    }

    public function test()
    {
        var_dump($this->getManagers());
    }
}

$request_method = strtolower($_SERVER['REQUEST_METHOD']);
$yuekeadmin = new YueKeAdmin($request_method, ENV('DB_USERNAME', 'root'), ENV('DB_PASSWORD', ''), ENV('DB_NAME'));
$yuekeadmin->process();
//$yuekeadmin->test();
