<?php
require_once ('list.handle.php');

$message = "";
$result = [];
if(isset($_GET['flag']) && !empty($_GET['flag'])){
    $flag = $_GET['flag'];
    $list = new listHandle($flag);
    $result = $list->getList();
    $title = $list->getTitle();
} else {
    $message = "出错了";
}

?>
<html>
<head>
    <meta charset="utf-8" />
    <meta lang="zh-CN" />
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=edge" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1, user-scalable=no" />
    <title><?php
            if(!empty($message)){
                echo "hahaha";
            } else {
                echo $title;
            }
        ?>
    </title>

    <style>
        body {
            text-align: center;
            background-color: #B9D3EE;
        }

        #content {
            background-color: #6f5499;
            background: -webkit-linear-gradient(120deg, #6f5499, #cdbfe3); /* Safari 5.1 - 6.0 */
            background: -o-linear-gradient(120deg, #6f5499, #cdbfe3); /* Opera 11.1 - 12.0 */
            background: -moz-linear-gradient(120deg, #6f5499, #cdbfe3); /* Firefox 3.6 - 15 */
            background: linear-gradient(120deg, #6f5499, #cdbfe3);
        }
    </style>

    <!--Bootstrap-->
    <link rel="stylesheet" href="lib/bootstrap/dist/js/bootstrap.min.js" />
</head>
<body>

<select id="select" class="form-control">
    <?php foreach($result as $key => $val): ?>
    <option value="<?php echo $val['url']?>"><?php echo $val['name'] ?></option>
    <?php endforeach; ?>
</select>

<div>
<?php

if($list->isVideo()) {
    echo <<<_END
<video id="video" width="320" height="240" src="{$result[0]['url']}" controls="controls">
</video>
_END;
} else {
/*    echo <<<_END
<iframe   src="{$result[0]['url']}"></iframe>
_END;*/
    echo '由于微信官方自带浏览器不能在线浏览ppt，请使用第三方浏览器浏览。';
}

?>
</div>

<div class="bs-docs-header" id="content">
    <div class="container">
        <h1><?php
            if(!empty($message)){
                echo "hahaha";
            } else {
                echo $title;
            }
            ?></h1>
    </div>
</div>

<div class="message"><?php echo $message ?></div>

<table border="1">
    <tr>
        <th>#</th>
        <th>files</th>
    </tr>

    <?php $count = 0; foreach($result as $key => $val): ?>
    <tr>
        <td><?php echo ++$count ?></td>
        <td><a href="<?php echo $result[$count-1]['url'] ?>"><?php echo $result[$count-1]['name']?></a></td>
    </tr>
    <?php endforeach; ?>
</table>
<script>
    var select = document.getElementById('select');

    select.onchange = function(){
        var video = document.getElementById('video');
        video.src = select.value;
    }
</script>

<!--js-->
<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
<script src="lib/bootstrap/dist/js/bootstrap.min.js"></script>

</body>
</html>