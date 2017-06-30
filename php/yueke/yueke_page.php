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
    <div class="row">
        <div class="col-md-6 col-md-offset-3" id="main_area">
            <div class="title"><h2>约课系统</h2></div>
            <hr/>
            <?php if (isset($params['success'])):?>
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <?php echo $params['success']; ?>
                </div>
            <?php endif;?>
            <?php if (isset($params['error'])):?>
                <div class="alert alert-danger" role="alert"><?php echo $params['error']; ?></div>
            <?php endif;?>
            <form id="choose_course_form" method="post" action="yueke.php">
                <input name="tag" value="<?php echo $tag ?>" hidden>
                <div class="form-group">
                    <label for="username">登录名</label>
                    <input type="text" class="form-control" id="username" name="manager_name" placeholder="登录名" required>
                </div>
                <div class="form-group">
                    <label for="pwd">登录密码</label>
                    <input type="password" class="form-control" id="pwd" name="manager_pwd" placeholder="登录密码" required>
                </div>
                <div class="form-group">
                    <label>当前约课标签</label>
                    <input class="form-control" type="text" name="tag" value="<?php echo $params['tag']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>班级</label>
                    <select class="form-control" name="class" required>
                        <?php for ($i = 0; $i < count($params['classes']); $i++): ?>
                            <option><?php echo $params['classes'][$i]; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>选课</label>
                    <select class="form-control" id="unit">
                        <?php for ($i = 0; $i < count($params['units']); $i++): ?>
                            <option <?php echo ($i == 0 ? 'selected="selected"' : '') ?>><?php echo $params['units'][$i]; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group">
                    <?php for ($k = 0; $k < count($params['units']); $k++): ?>
                    <?php $current_unit = $params['units'][$k]; ?>
                        <table class="table table-bordered" id="<?php echo str_replace(' ', '_', $current_unit); ?>" style="display: none;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>周一</th>
                                    <th>周二</th>
                                    <th>周三</th>
                                    <th>周四</th>
                                    <th>周五</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i = 1; $i <= 4; $i++): ?>
                                    <tr>
                                        <th scope="row"><?php echo $i * 2 - 1 ?>-<?php echo $i * 2 ?></th>
                                        <?php for($j = 1; $j <= 5; $j++): ?>
                                        <?php
                                            $class = $params['has_choosed'][$current_unit][$i][$j]['class'];
                                            $value = $params['has_choosed'][$current_unit][$i][$j]['value'];
                                        ?>
                                        <td class="course_item <?php echo (!empty($class) ? 'has_choosed' : '') ?>" value="<?php echo $value ?>"><?php echo $class; ?></td>
                                        <?php endfor; ?>
                                    </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                    <?php endfor; ?>
                    <input id="course_choosed_result" type="text" name="course_choosed_result" value="" hidden>
                </div>
                <hr>
                <input type="button" class="btn btn-primary" id="course_form_submit_button" value="提交">
            </form>
        </div>
        <p class="bg-default footer col-md-12"><a href="yueke_admin.php">约课系统后台</a></p>
    </div>

    <!-- js -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/yueke.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
