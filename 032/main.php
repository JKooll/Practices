<?php

/**
 * 获取题目列表并保存进数据库
 * todo
 * - console 进度条
 */

include_once "./vendor/autoload.php";

$hoj_url = 'http://acm.hdu.edu.cn';
$hoj_problems_list_url = "http://acm.hdu.edu.cn/listproblem.php";
$hoj_problems_list_suffix = "?vol=";
$show_problem = '/showproblem.php?pid=';
$page = 1;

$url = $hoj_problems_list_url . $hoj_problems_list_suffix . $page;
$request = Requests::get($url);

$page_content = $request->body;

$html = new simple_html_dom();

$html->load($page_content);

//获取总页数
$selector_total_page_p = "p[class=footer_link]";

$result_p = $html->find($selector_total_page_p, 0);

$result_a = $result_p->find('a');

$pages = array();

//解析并保存所有问题
foreach ($result_a as $page) {
    $pages[] = $page->attr['href'];
    echo $url = $hoj_url . '/' . $page->attr['href'];
    $page = Requests::get($url)->body;
    parser($html, $page);
}

//解析当前页面
function parser($html, $page)
{
    $html->load($page);

    $selector = "table script";

    $problems_list_dom = $html->find($selector, 1);

    $problems_list_str = trim($problems_list_dom->innertext);

    $problems_list_arr = array();

    while(!empty($problems_list_str)) {
        $start = stripos($problems_list_str, 'p');
        $end = stripos($problems_list_str, ';');
        $problem_str = substr($problems_list_str, $start, $end - $start + 1);
        $problems_list_arr[] = eval('return ' . $problem_str);
        $problems_list_str = substr($problems_list_str, $end + 1);
    }

    save($problems_list_arr);
}

/**
 * 渲染dom节点的函数
 * 详见航电problem list page源码
 * @param $color
 * @param $pid
 * @param $solved
 * @param $title
 * @param $ac -- accept
 * @param $sub -- submit
 * @return array
 */
function p($color, $pid, $solved, $title, $ac, $sub)
{
    $ratio = 0.00;
    if($sub > 0)
    {
        $ratio = round($ac * 100 / $sub + 0.005, 2);
    }

    $isSolved = $solved == 5 ? true : false;

    return [
        'color' => $color,
        'pid' => $pid,
        'solved' => $solved,
        'title' => $title,
        'ac' => $ac,
        'sub' => $sub,
        'ratio' => $ratio,
        'isSolved' => $isSolved,
    ];
}

function save($problems_list_arr)
{
    $database = "hoj";
    $table = "problems";

    //连接mysql
    $db_config = [
        'database_type' => 'mysql',
        'database_name' => $database,
        'server' => 'localhost',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8'
    ];

    $database = new \Medoo\Medoo($db_config);

    $query = '';

    foreach($problems_list_arr as $problem) {
        $database->insert($table, $problem);
    }

    echo "题目获取完成，保存到数据库，题目数量为：" . count($problems_list_arr);
}



