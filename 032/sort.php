<?php

/**
 * 将问题列表按照提交量由大到小进行排序
 */

include_once "./vendor/autoload.php";

function quickSort($array)
{
    if(!isset($array[1]))
        return $array;

    $mid = $array[0]; //获取一个用于分割的关键字，一般是首个元素
    $leftArray = array();
    $rightArray = array();
    $equalArray = array();

    foreach($array as $v)
    {
        if($v['sub'] < $mid['sub'])
            $rightArray[] = $v;  //把比$mid小的数放到一个数组里
        if($v['sub'] > $mid['sub'])
            $leftArray[] = $v;   //把比$mid大的数放到另一个数组里
        if($v['sub'] == $mid['sub'] && $v['pid'] != $mid['pid'])
            $equalArray[] = $v;
    }

    $leftArray = quickSort($leftArray); //把比较小的数组再一次进行分割
    $leftArray[] = $mid;//把分割的元素加到小的数组后面，不能忘了它哦
    $leftArray = array_merge($leftArray, $equalArray);

    $rightArray = quickSort($rightArray);  //把比较大的数组再一次进行分割
    return array_merge($leftArray,$rightArray);  //组合两个结果
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

$database = connect_db();
$table = "problems";

//获取问题列表并排序
$statement = "SELECT * FROM $table";
$test_arr = $database->query($statement)->fetchAll(PDO::FETCH_ASSOC);

$result = quickSort($test_arr);

//保存排完序的问题列表
$i = 0;
foreach ($result as $problem) {
    $database->insert('problems_sorted', $problem);
    echo "保存第{$i}个问题:{$problem['title']}\n";
    $i++;
}