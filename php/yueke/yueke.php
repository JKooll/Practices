<?php
include_once "vendor/autoload.php";

use Medoo\Medoo;

class YueKe
{
    use common;

    private $request_method; //保存用户请求方式
    private $yueke_page = "yueke_page.php"; //约课主页面
    private $yeuke_error = "yueke_error.php"; //出错
    private $yueke_success = "yuele_success.php"; //成功
    private $medoo; //保存数据库连接实例
    private $yueke_table = "yueke"; //保存约课记录
    private $tag; //当前约课标签
    private $units; //课程列表
    private $classes; //班级列表
    private $weeks = ['mo' => 1, 'tu' => 2, 'we' => 3, 'th' => 4, 'fr' => 5]; //星期
    private $course_time = ['1_2' => 1, '3_4' => 2, '5_6' => 3, '7_8' => 4]; //上课时间

    public function __construct($request_method, $db_username, $db_password, $db_name)
    {
        $this->request_method = strtolower($request_method);
        $this->medoo = MyDB::connection($db_username, $db_password, $db_name);
        $this->create_table();
        $this->classes = $this->getClasses();
        $this->units = $this->getUnits();
        $this->tag = $this->getTag();
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
                    $course_items[$this->units[$k]][$i][$j] = ['class' => '', 'value' => $course_item];
                }
            }
        }

        //获取已选课程
        for($q = 0; $q < count($this->units); $q++) {
            $result = $this->medoo->select(
                $this->yueke_table,
                ['unit', 'class', 'course_item'],
                ['AND' => [
                    'tag' => $this->tag,
                    'unit' => $this->units[$q]
                    ]
                ]
            );
            foreach ($result as $key => $val) {
                $course_item_arr = explode('_', $val['course_item']);
                $course_items[$this->units[$q]][$this->course_time[$course_item_arr[1] . '_' . $course_item_arr[2]]][$this->weeks[$course_item_arr[0]]] = ['class' => $val['class'], 'value' => $val['course_item']];
            }
        }

        $params['has_choosed'] = $course_items;
        $params['units'] = $this->units;
        $params['tag'] = $this->tag;
        $params['classes'] = $this->classes;
        //渲染并返回页面
        return $this->view($this->yueke_page, $params);
    }

    private function post()
    {
        if (!$this->validate()) {
            return $this->error(['error' => '您没有获取相关权限']);
        }

        $tag = isset($_POST['tag']) ? $_POST['tag'] : '';
        $class = isset($_POST['class']) ? $_POST['class'] : '';
        $course_choosed_result = explode('+', trim($_POST['course_choosed_result']));
        foreach($course_choosed_result as $key => $val) {
            if (empty($val)) {
                continue;
            }
            $single_unit = explode('-', trim($val));
            $unit = $single_unit[0];
            $course_choosed_arr = explode('&', trim($single_unit[1], '&'));
            foreach ($course_choosed_arr as $key => $val) {
                $where = [
                    'tag' => $tag,
                    'class' => $class,
                    'unit' => $unit,
                    'course_item' => $val,
                ];
                if (!$this->medoo->has($this->yueke_table, $where)) {
                    $this->medoo->insert($this->yueke_table, $where);
                }
            }
        }
        return $this->success(['success' => '约课成功']);
    }

    private function view($page, $params = '')
    {
        $tag = $this->tag;
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

    private function create_table()
    {
        $yueke_table_create_query =  "CREATE TABLE IF NOT EXISTS {$this->yueke_table} (
            id INT PRIMARY KEY AUTO_INCREMENT,
            tag VARCHAR(50),
            class VARCHAR(50),
            unit VARCHAR(50),
            course_item VARCHAR(200)
        )CHARACTER SET utf8;";
        MyDB::createTable($this->medoo, $yueke_table_create_query);
    }

    private function validate()
    {
        $manager_name = isset($_POST['manager_name']) ? $_POST['manager_name'] : '';
        $manager_pwd = isset($_POST['manager_pwd']) ? $_POST['manager_pwd'] : '';
        $managers = $this->getManagers();
        $exist = false;
        for ($i = 0; $i < count($managers); $i++) {
            if($managers[$i]['manager_name'] === $manager_name && $managers[$i]['manager_pwd'] == $manager_pwd) {
                $exist = true;
                break;
            }
        }
        return $exist;
    }

    private function getManagers()
    {
        $managers_str = ENV('MANAGERS');
        $managers_arr = explode('&', $managers_str);
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
}

$request_method = strtolower($_SERVER['REQUEST_METHOD']);
$yueke = new YueKe($request_method, ENV('DB_USERNAME', 'root'), ENV('DB_PASSWORD', '') ,ENV('DB_NAME', ''));
$yueke->process();
