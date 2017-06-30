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
    private $tag; //当前约课标签
    private $units;
    private $weeks = ['mo' => 1, 'tu' => 2, 'we' => 3, 'th' => 4, 'fr' => 5]; //星期
    private $course_time = ['1_2' => 1, '3_4' => 2, '5_6' => 3, '7_8' => 4]; //上课时间

    public function __construct($request_method, $db_username, $db_password, $db_name)
    {
        $this->request_method = $request_method;
        $this->medoo = MyDB::connection($db_username, $db_password, $db_name);
        $this->tag = $this->getTag();
        $this->units = $this->getUnits();
    }

    public function process()
    {
        if (!$this->validate()) {
            return $this->view($this->yueke_admin_login_page, ['error' => '请输入正确的登录名和密码']);
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
        $params['units_str'] = ENV('UNITS');
        $params['classes'] = $this->getClasses();
        $params['tag'] = ENV('TAG');
        $params['managers'] = $this->getManagers();
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
                $this->addManager();
                break;

            default:
                return $this->get();
                break;
        }
        return $this->success();
    }

    private function setting()
    {
        //要设置的配置标签
        $setting_arr = ['UNITS', 'TAG', 'CLASSES'];
        for($i = 0; $i < count($setting_arr); $i++) {
            set_env($setting_arr[$i], trim($_POST[strtolower($setting_arr[$i])], '+&'));
        }
    }

    private function changeCourse()
    {

    }

    private function addManager()
    {
        $_POST['managers'] = isset($_POST['managers']) ? $_POST['managers'] : '';
        $managers_str = str_replace('=', '+', trim($_POST['managers'], '&'));
        return set_env('MANAGERS', $managers_str);
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

    private function setClasses()
    {
        $classes_str = isset($_POST['classses']) ? $_POST['classes'] : '';
        return set_env('CLASSES', $classes_str);
    }

    private function getClasses()
    {
        $classes = ENV('CLASSES');
        $classes_arr = explode('+', $classes);
        return $classes_arr;
    }

    private function view($page, $params = [])
    {
        $tag = $this->tag;
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
        $root_name = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $root_pwd = isset($_REQUEST['pwd']) ? $_REQUEST['pwd'] : '';
        if ($root_name === ENV('ROOT_NAME') && $root_pwd === ENV('ROOT_PWD')) {
            return true;
        }
        return false;
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
