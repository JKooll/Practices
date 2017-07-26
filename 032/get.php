<?php

/**
 * 从获取一个问题
 */

include_once './vendor/autoload.php';

if(isset($_REQUEST['solved'])) {
    solved($_REQUEST['solved']);
} else {
    if(!isset($_REQUEST['id'])) {
        init();
    } else {
        get($_REQUEST['id']);
    }
}

//连接数据库并返回数据库连接实例
function connect_db()
{
    $database = "hoj";

    //连接mysql
    $db_config = [
        'database_type' => 'mysql',
        'database_name' => $database,
        'server' => 'localhost',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8'
    ];

    return new \Medoo\Medoo($db_config);
}

function init()
{
    $url_prefix = 'http://acm.hdu.edu.cn/showproblem.php?pid=';
    $database = connect_db();
    $table = 'problems_sorted';
    $problem = first($database, $table);
    get($problem['id']);
}

function get($id)
{
    $url_prefix = 'http://acm.hdu.edu.cn/showproblem.php?pid=';
    $database = connect_db();
    $table = 'problems_sorted';
    $problem = $database->select($table, '*', ['id' => $id])[0];
    $url = $url_prefix . $problem['pid'];
    $solved_url = 'http://localhost/projects/hoj_php/get.php?solved=' . $problem['id'];
    $pre_problem = _pre($database, $table, $problem['id']);
    $pre_url = 'http://localhost/projects/hoj_php/get.php?id=' . $pre_problem['id'];
    $next_problem = _next($database, $table, $problem['id']);
    $next_url = 'http://localhost/projects/hoj_php/get.php?id=' . $next_problem['id'];
    view($url, $pre_url, $next_url, $solved_url, $problem);
}

function view($url, $pre_url, $next_url, $solved_url, $problem)
{
    echo "<div style='text-align: center;font-size: 200%;'><a href='{$url}'>{$problem['pid']} : {$problem['title']}</a><br><br><br><button><a href='{$solved_url}'>solved</a></button><br><br><br><button><a href='{$next_url}'>next</a></button><button><a href='{$pre_url}'>pre</a></button></div>";
}

function first($database, $table)
{
    return $database->select($table, "*", ['LIMIT'=>[0,1]])[0];

}

function _next($database, $table, $id)
{
    $pre_quesiton = $database->select($table, "*", ['id' => $id])[0];
    $problem = $database->select($table, "*", ['sub[<]' => $pre_quesiton['sub'], 'LIMIT' => [0, 1]]);
    if(empty($problem)) {
        return $pre_quesiton;
    }
    return $problem[0];
}

function _pre($database, $table, $id)
{
    $pre_quesiton = $database->select($table, "*", ['id' => $id])[0];
    $problem = $database->select($table, "*", ['sub[>]' => $pre_quesiton['sub']]);
    if(empty($problem)) {
        return $pre_quesiton;
    }
    return $problem[count($problem) - 1];
}

function solved($id)
{
    $database = connect_db();
    $problem = $database->select('problems_sorted', '*', ['id' => $id])[0];
    $database->insert('solved', $problem);
    $database->delete('problems_sorted', ['id' => $id]);
    $url="http://localhost/projects/hoj_php/get.php";
    echo "<div style='text-align: center;font-size: 200%;'>Solved!<br><br><br><button><a href='{$url}'>Next</a></button></div>";
}

