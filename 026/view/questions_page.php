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
        <h1 class="text-center">答疑系统</h1>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <h2>问题列表</h2>
            </div>
            <div class="col-md-2 col-md-offset-5">
                <a href="create_questions.php">
                    <button type="button" name="button" class="btn btn-primary btn-lg">
                        提问
                    </button>
                </a>
            </div>
        </div>
        <h1>问题列表</h1>
        <?php if (empty($data['questions_list'])): ?>
            问题列表为空。
        <?php else:?>
            <ul class="list-group questions_list">
                <?php for($i = 0; $i < count($data['questions_list']); $i++): ?>
                    <li class="list-group-item">
                        <a href="show_questions.php?id=<?php echo $data['questions_list'][$i]['id']?>">
                            <?php echo $data['questions_list'][$i]["title"]; ?>
                            <span class="badge"><?php echo $data['questions_list'][$i]['answers_count']; ?></span>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        <?php endif; ?>
    </div>

    <!-- js -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
