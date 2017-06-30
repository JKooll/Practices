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
            <div class="title"><h2>约课系统后台管理</h2></div>
            <?php if (isset($params['success'])):?>
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <?php echo $params['success']; ?>
                </div>
            <?php endif;?>
            <?php if (isset($params['error'])):?>
                <div class="alert alert-danger" role="alert"><?php echo $params['error']; ?></div>
            <?php endif;?>
            <hr/>
            <div class="form-group">
                <label for="username">登录名</label>
                <input type="text" class="form-control" id="username" name="name" placeholder="登录名" required>
            </div>
            <div class="form-group">
                <label for="pwd">登录密码</label>
                <input type="password" class="form-control" id="pwd" name="password" placeholder="登录密码" required>
            </div>
            <ul id="myTabs" class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#result" id="result-tab" rol="tab" data-toggle="tab" aria-controls="result" aria-expanded="true">约课结果</a>
                </li>
                <li role="presentation">
                    <a href="#setting" role="tab" id="setting-tab" data-toggle="tab" aria-controls="setting" aria-expanded="false">设置</a>
                </li>
                <li role="presentation">
                    <a href="#manager" role="tab" id="manager-tab" data-toggle="tab" aria-controls="manager" aria-expanded="false">管理员</a>
                </li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div role="tabpanel" class="tab-pane fade active in" id="result" aria-labelledby="reuslt-tab">
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
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="setting" aria-labelledby="reuslt-tab">
                    <div class="alert alert-danger alert-dismissible fade in danger_status" role="alert" style="display:none;">
                    </div>
                    <div class="alert alert-success alert-dismissible fade in success_status" role="alert" style="display:none;">
                    </div>
                    <div class="form-group">
                        <label for="set_classes">班级</label>
                        <ul class="list-group" id="set_classes">
                            <?php for ($i = 0; $i < count($params['classes']); $i++): ?>
                                <li class="list-group-item class">
                                    <div class="form-inline">
                                        <input type="text" class="form-control" name="class" value="<?php echo $params['classes'][$i]; ?>" readonly>
                                        <button class="btn btn-danger delete_class"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                                    </div>
                                </li>
                            <?php endfor; ?>
                            <li class="list-group-item" id="add_class_li">
                                <div class="form-inline">
                                    <input type="text" class="form-control" name="class" value="">
                                    <button class="btn btn-success add_class"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="form-group">
                        <label for="set_units">课程</label>
                        <ul class="list-group">
                            <?php for ($i = 0; $i < count($params['units']); $i++): ?>
                                <li class="list-group-item unit">
                                    <div class="form-inline">
                                        <input type="text" class="form-control" id="set_units" name="unit" value="<?php echo $params['units'][$i]; ?>" readonly>
                                        <button class="btn btn-danger delete_unit"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                                    </div>
                                </li>
                            <?php endfor; ?>
                            <li class="list-group-item unit" id="add_unit_li">
                                <div class="form-inline">
                                    <input type="text" class="form-control" id="set_units" name="unit" value="">
                                    <button class="btn btn-success add_unit"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                                </div>
                            </li>
                        </ul>

                    </div>
                    <form id="setting_form" method="post" action="yueke_admin.php">
                        <input type="text" name="form_tag" value="setting" hidden>
                        <div class="form-group">
                            <label for="set_units">当前选课标签</label>
                            <input type="text" class="form-control" id="set_tag" name="tag" value="<?php echo $params['tag']; ?>" placeholder="更改选课标签，等于创建一个新的选课">
                        </div>
                        <hr>
                        <button class="btn btn-primary" id="setting_form_submit_button">保存</button>
                    </form>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="manager" aria-labelledby="manager-tab">
                    <div class="alert alert-danger alert-dismissible fade in danger_status" role="alert" style="display:none;">
                    </div>
                    <div class="alert alert-success alert-dismissible fade in success_status" role="alert" style="display:none;">
                    </div>
                    <ul class="list-group"id="manager_list">
                        <?php for ($i = 0; $i < count($params['managers']); $i++): ?>
                            <li class="list-group-item manager">
                                <div class="form-inline">
                                    <div class="form-group">
                                        <label>登录名</label>
                                        <input type="text" class="form-control manager_name" name="name" value="<?php echo $params['managers'][$i]['manager_name']; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>密码</label>
                                        <input type="password" class="form-control manager_pwd" name="pwd" value="<?php echo $params['managers'][$i]['manager_pwd']; ?>" readonly>
                                    </div>
                                    <button class="btn btn-danger delete_manager"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                                </div>
                            </li>
                        <?php endfor; ?>
                        <li class="list-group-item">
                            <div class="form-inline">
                                <div class="form-group">
                                    <label>登录名</label>
                                    <input type="text" class="form-control manager_name" placeholder="Jane Doe">
                                </div>
                                <div class="form-group">
                                    <label>密码</label>
                                    <input type="password" class="form-control manager_pwd" placeholder="***">
                                </div>
                                <button class="btn btn-success add_manager"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                            </div>
                        </li>
                    </ul>
                    <form action="yueke_admin.php" method="post" id="manager_form">
                        <input type="text" name="form_tag" value="add_manager" hidden="hidden">
                        <input type="text" name="managers" value="" hidden="hidden">
                        <button class="btn btn-primary" id="manager_form_submit_button">保存</button>
                    </form>
                </div>
            </div>
        </div>
        <p class="bg-default footer col-md-12"><a href="yueke.php">约课系统</a></p>
    </div>

    <!-- js -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/yueke_admin.js"></script>
</body>
</html>
