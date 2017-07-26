<?php
$uid = '';
$qid = '';

if(isset($_GET['receive_uid'])) {
    $uid = $_GET['receive_uid'];
}

if(isset($_GET['qid'])) {
    $qid = $_GET['qid'];
}
?>
<html>
<head>
    <meta charset="utf8" />

    <link rel="stylesheet" href="src/css/sendClient.css">

    <title>sendClient</title>
</head>
<body>
    <input type="hidden" id="uid" value="<?php echo $uid ?>" />
    <input type="hidden" id="qid" value="<?php echo $qid ?>" />
    <input type="text" id="send"/>
    <button onclick="send()">发送</button>
    <div>
        alpha:<lable id="alpha"></lable><br />
        beta:<lable id="beta"></lable><br />
        gamma:<lable id="gamma"></lable><br />
    </div>

    <div id="show"></div>

    <script src="src/js/sendClient.js"></script>
</body>
</html>