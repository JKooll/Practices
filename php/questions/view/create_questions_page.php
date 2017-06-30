<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>答疑系统</title>

    <!-- css -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/questions.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div class="container">
        <?php if (isset($data['status'])): ?>
            <?php if ($data['status']['code'] == 'success'): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $data['status']['content']?>
                </div>
            <?php else: ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $data['status']['content']?>
                </div>
            <?php endif;?>
        <?php endif;?>
        <form method="post" action="create_questions.php">
            <div class="form-group">
                <label>姓名</label>
                <input class="form-control" type="text" name="author" placeholder="你的名字" required>
            </div>
            <div class="form-group">
                <label>邮箱</label>
                <input type="email" class="form-control" name="email" placeholder="你的邮箱">
            </div>
            <div class="form-group">
                <label>问题标题</label>
                <input class="form-control" type="text" name="question_title" placeholder="你的问题" required>
            </div>
            <div class="form-group">
                <label>问题描述</label>
                <textarea required class="form-control" name="question_content" rows="8" cols="80" placeholder="在这里写下你的疑问"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">提交</button>
            <a href="questions.php">
                <button type="button" class="btn btn-primary">问题列表</button>
            </a>
        </form>
    </div>

    <!-- js -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
