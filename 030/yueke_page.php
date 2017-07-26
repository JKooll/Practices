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
                <div class="form-group">
                    <label>当前用户</label>
                    <input class="form-control" type="text" name="username" value="<?php echo $params['username']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>选课</label>
                    <select class="form-control" id="unit">
                        <?php for ($i = 0; $i < count($params['units']); $i++): ?>
                            <option <?php echo ($i == 0 ? 'selected="selected"' : '') ?> value="<?php echo $params['units'][$i]['code']?>" place="<?php echo $params['units'][$i]['place']; ?>"><?php echo $params['units'][$i]['name']; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group">
                    <?php for ($k = 0; $k < count($params['units']); $k++): ?>
                    <?php $current_unit = $params['units'][$k]['code']; ?>
                        <div class="form-inline" id="<?php echo $current_unit; ?>" style="display: none;">
                            <div class="form-group">
                                <label>开始时间</label>
                                <input class="form-control" type="date" name="start_time" value="<?php echo $params['has_choosed'][$current_unit]['start_time']; ?>">
                            </div>
                            <div class="form-group">
                                <label>结束时间</label>
                                <input class="form-control" type="date" name="end_time" value="<?php echo $params['has_choosed'][$current_unit]['end_time']; ?>">
                            </div>
                        </div>
                    <?php endfor; ?>
                    <table class="table table-bordered" id="units_table">
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
                                        $is_has_choosed = $params['has_choosed'][$i][$j]['is_has_choosed'];
                                        $value = $params['has_choosed'][$i][$j]['value'];
                                        $unit = $params['has_choosed'][$i][$j]['unit'];
                                        $unit_name = $unit['name'];
                                        $unit_code = $unit['code'];
                                        $unit_place = $unit['place'];
                                    ?>
                                    <td class="course_item <?php echo (!empty($is_has_choosed) ? 'choosed' : '') ?>" value="<?php echo $value ?>" course="<?php echo $unit_code ?>">
                                        <?php
                                            if (!empty($unit_name)) {
                                                echo "{$unit_name}@{$unit_place}";
                                            }
                                        ?>
                                    </td>
                                    <?php endfor; ?>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                    <input id="course_choosed_result" type="text" name="course_choosed_result" value="" hidden>
                </div>
                <hr>
                <input type="button" class="btn btn-primary" id="course_form_submit_button" value="提交">
            </form>
        </div>

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">帮助</button>

        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class=container><p><h2>选择科目[选课] => 开始时间 => 结束时间 => 选择上课时间 => 提交</h2></p></div>
                </div>
            </div>
        </div>
        <p class="bg-default footer col-md-12"><a href="yueke_admin.php">约课系统后台</a></p>
    </div>

    <!-- js -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/yueke.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
