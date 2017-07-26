<!DOCTYPE html>
<html lang="zh">

<head>

    <meta charset="UTF-8">
    <title>Title</title>

</head>

<body>

<input type="text" id="sendtext" />
<input type="button" value="发送" onclick="send()"/>

<div id="show"></div>

<div id="qrcode"><img src="" /></div>

<div>
    alpha:<lable id="alpha"></lable><br />
    beta:<lable id="beta"></lable><br />
    gamma:<lable id="gamma"></lable><br />
</div>

<canvas id="view"></canvas>

<script src="src/js/receiveClient.js"></script>
<script src="src/js/game.js"></script>

</body>

</html>