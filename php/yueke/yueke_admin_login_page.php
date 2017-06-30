<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>约课系统</title>

    <!-- css -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/yueke.css">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div class="container">
        <div class="row">
            <div id="main_area" class="col-md-offset-3 col-md-6">
                <form class="form-horizontal" method="post" action="yueke_admin.php">
                    <div class="heading">用户登录</div>
                    <?php if (isset($params['success'])):?>
                        <div class="alert alert-success" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <?php echo $params['success']; ?>
                        </div>
                    <?php endif;?>
                    <?php if (isset($params['error'])):?>
                        <div class="alert alert-danger" role="alert"><?php echo $params['error']; ?></div>
                    <?php endif;?>
                    <div class="form-group">
                        <label>登录名:</label>
                        <input type="text" name="name" class="form-control" placeholder="登录名">
                    </div>
                    <div class="form-group">
                        <label>密码</label>
                        <input type="password" name="pwd" class="form-control" placeholder="密　码">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-default">登录</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- js -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
