<?php
include_once "vendor/autoload.php";

use Medoo\Medoo;

class YueKe
{
    use Common;

    private $request_method; //保存用户请求方式
    private $yueke_page = "yueke_page.php"; //约课主页面
    private $yeuke_error = "yueke_error.php"; //出错
    private $yueke_success = "yuele_success.php"; //成功
    private $medoo; //保存数据库连接实例
    private $yueke_table = "yueke"; //保存约课记录
    private $users_table = "users"; //保存用户
    private $units_table = "units"; //保存课程
    private $units; //课程列表
    private $weeks = ['mo' => 1, 'tu' => 2, 'we' => 3, 'th' => 4, 'fr' => 5]; //星期
    private $course_time = ['1_2' => 1, '3_4' => 2, '5_6' => 3, '7_8' => 4]; //上课时间
    private $username = "";

    public function __construct($request_method, $db_username, $db_password, $db_name)
    {
        $this->login();
        $this->request_method = strtolower($request_method);
        $this->medoo = $this->db();
        CreateTable::create($this->medoo);
        $this->classes = $this->getClasses();
        $this->units = $this->getUnits();
        $this->username = $_SERVER['PHP_AUTH_USER'];
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

    private function get($params = [])
    {
        $db = $this->medoo;
        $user = $db->get($this->users_table, '*', ['username' => $this->username]);
        $course_items = [];
        $units = $this->getUnits();

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
                $course_items[$i][$j] = ['is_has_choosed' => '', 'value' => $course_item, 'unit' => ['name' => '', 'code' => '', 'place' => '']];
            }
        }

        //获取已选课程
        for($q = 0; $q < count($units); $q++) {
            $result = $this->medoo->get(
                $this->yueke_table,
                ['unit_code', 'course_item', 'start_time', 'end_time'],
                [
                    'username' => $user['username'],
                    'unit_code' => $units[$q]['code']
                ]
            );
            $unit = $db->get($this->units_table, "*", ['code' => $result['unit_code']]);
            if (!$result) {
                $course_items[$units[$q]['code']]['start_time'] = date('Y-m-d');
                $course_items[$units[$q]['code']]['end_time'] = date('Y-m-d');
                continue;
            }
            $course_items[$units[$q]['code']]['start_time'] = str_replace('_', '-', $result['start_time']);
            $course_items[$units[$q]['code']]['end_time'] = str_replace('_', '-', $result['end_time']);
            $course_items_arr = explode("&", $result['course_item']);
            foreach ($course_items_arr as $key => $val) {
                if (empty($val)) {
                    continue;
                }
                $course_item_arr = explode('_', $val);
                $course_item_obj = &$course_items[$this->course_time[$course_item_arr[1] . '_' . $course_item_arr[2]]][$this->weeks[$course_item_arr[0]]];
                $course_item_obj =
                    [
                        'is_has_choosed' => 'true',
                        'value' => $val,
                        'unit' => $unit
                    ];
            }
        }

        $params['has_choosed'] = $course_items;
        $params['units'] = $units;
        $params['username'] = $this->username;
        //渲染并返回页面
        return $this->view($this->yueke_page, $params);
    }

    private function post()
    {
        $username = $this->username;
        $db = $this->medoo;
        $user = $db->get($this->users_table, "*", ['username' => $username]);
        $course_choosed_result = explode('+', trim($_POST['course_choosed_result']));
        foreach($course_choosed_result as $key => $val) {
            if (empty($val)) {
                continue;
            }
            $unit_arr = $this->parseCourseChoosedStr($val);
            $unit_code = $unit_arr['unit'];
            $course_choosed_str = $unit_arr['course_choosed_str'];
            $start_time = $unit_arr['start_time'];
            $end_time = $unit_arr['end_time'];
            $where = [
                'username' => $user['username'],
                'unit_code' => $unit_code,
                'course_item' => $course_choosed_str,
                'start_time' => $start_time,
                'end_time' => $end_time
            ];
            $selector = ['username' => $user['username'], 'unit_code' => $unit_code];
            if (!$this->medoo->has($this->yueke_table, $selector)) {
                $db->insert($this->yueke_table, $where);
            } else {
                $db->update($this->yueke_table, $where, $selector);
            }
        }
        return $this->success(['success' => '约课成功']);
    }

    private function parseCourseChoosedStr($single_unit)
    {
        $temp_arr = explode('-', trim($single_unit));
        $unit = $temp_arr[0];
        $temp_arr2 = explode(':', trim($temp_arr[1], '&'));
        $course_choosed_str = trim($temp_arr2[0], '&');
        $start_time = explode('*', trim($temp_arr2[1], '&'))[0];
        $end_time = explode('*', trim($temp_arr2[1], '&'))[1];
        return [
            'unit' => $unit,
            'course_choosed_str' => $course_choosed_str,
            'start_time' => $start_time,
            'end_time' => $end_time
        ];
    }

    private function view($page, $params = '')
    {
        if(!file_exists($page)) {
            return $this->error();
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

    private function getManagers()
    {
        $managers_str = ENV('MANAGERS');
        $managers_arr = explode('&', $managers_str);
        $managers_arr = array_filter($managers_arr, function($item) {
            if (empty($item)) {
                return false;
            }
            return true;
        });
        $managers = [];
        for($i = 0; $i < count($managers_arr); $i++) {
            $single_manager_arr = explode('+', $managers_arr[$i]);
            $managers[$i] = [
                'manager_name' => $single_manager_arr[0],
                'manager_pwd' => $single_manager_arr[1]
            ];
        }
        return $managers;
    }

    private function validate()
    {
        if (empty($_SERVER['PHP_AUTH_USER']) || empty($_SERVER['PHP_AUTH_PW'])) {
            return false;
        }
        $username = $_SERVER['PHP_AUTH_USER'];
        $password = $_SERVER['PHP_AUTH_PW'];
        $db = $this->db();
        $result = $db->has($this->users_table, ['username' => $username]);
        if (!$result) {
            return false;
        }
        $manager = $db->get($this->users_table, ['password', 'last_access'], ['username' => $username]);
        $real_password = $manager['password'];
        if ($real_password !== $password) {
            return false;
        }
        $now = time();
        $last_access = $manager['last_access'];
        if ($now - $last_access > 60) {
            $db->update($this->users_table, ['last_access' => $now], ['username' => $username]);
            return false;
        }
        return true;
    }
}

$request_method = strtolower($_SERVER['REQUEST_METHOD']);
$yueke = new YueKe($request_method, ENV('DB_USERNAME', 'root'), ENV('DB_PASSWORD', '') ,ENV('DB_NAME', ''));
$yueke->process();
