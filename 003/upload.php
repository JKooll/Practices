<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <title>上传</title>
</head>
<body>
<div style="text-align: center;font-size: 300%;">资源上传接口
    <select id="path" onchange="change()">
        <option value="002/" >课文讲解</option>
        <option value="003/" >歌曲演唱</option>
        <option value="004/" >原创广告</option>
        <option value="005/" >戏曲表演</option>
        <option value="006/" >ppt</option>
        <option value="007/">微课堂</option>
    </select>
    <form id="f1" method="post" action="" enctype="multipart/form-data">

    </form>

</div>
<br /><br />
<div style="text-align: center;font-size: 300%;">试题上传接口<br />
    试题：<input type="text" name="title" id="title"/>
    选项：
    <select name="answer" id="answer">
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="C">C</option>
    </select>
    <button onclick="exeupload()">上传试题</button>
</div>>
</body>
</html>