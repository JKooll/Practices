<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>这是手柄！！！</title>
    <link rel="stylesheet" href="../css/device.css"/>
    <script src="../js/config.js"></script>
    <script src="../js/device.js"></script>
</head>
<body>
<input type="range" id="range" value="50"/>
<input type="hidden" name="room_id" value="<?php echo isset($_GET['room_id']) ? $_GET['room_id'] : 0 ?>"/>
<div></div>
</body>
</html>