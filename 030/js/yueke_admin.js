
$(function() {
    $('.course_item a').click(function (e) {
        $(this).popover('show');
    });

    $('#myTabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    $('#unit').change(function() {
        $('#unit > option:selected').each(function() {
            $("#" + $(this).val()).show();
        });
        $('#unit > option:not(:selected)').each(function() {
            $("#" + $(this).val()).hide();
        });
    }).trigger('change');

    //添加管理员
    $('.add_manager').click(function() {
        let manager_name = $(this).siblings().find('.manager_name').val();
        let manager_pwd = $(this).siblings().find('.manager_pwd').val();
        if (isEmpty(manager_name)) {
            renderStatus('danger', '请输入登录名！');
            return;
        }
        if (isEmpty(manager_pwd)) {
            renderStatus('danger', '请输入密码！');
            return;
        }
        let li_item_dom = '<li class="list-group-item manager">\
            <div class="form-inline">\
                <div class="form-group">\
                    <label>登录名</label>\
                    <input type="text" class="form-control manager_name" value="' + manager_name + '"readonly>\
                </div>\
                <div class="form-group">\
                    <label>密码</label>\
                    <input type="password" class="form-control manager_pwd" value="' + manager_pwd + '"readonly>\
                </div>\
                <button class="btn btn-danger delete_manager"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>\
            </div>\
        </li>';
        $(this).parents('li').before(li_item_dom);
        renderStatus('success', '添加成功, 请保存!');
        //初始化管理员添加框
        $(this).siblings().find('.manager_name').val('');
        $(this).siblings().find('.manager_pwd').val('');
        $('.delete_manager').click(function() {
            $(this).parents('li').remove();
        });
    });

    //绑定delete manager button 事件， 删除管理员
    $('.delete_manager').click(function() {
        $(this).parents('li').remove();
    });

    //manager form sumbmit button event handler
    $('#manager_form_submit_button').click(function(e) {
        e.preventDefault();
        let managers = getManagers();
        let managers_str = '';
        for(manager in managers) {
            managers_str += managers[manager]['manager_name'] + "=" + managers[manager]['manager_pwd'] + '&';
        }
        $(this).siblings('[name=managers]').attr('value', managers_str);
        addUserInfo("#manager_form");
        $('#manager_form').trigger('submit');
    });

    // //添加classes
    // $('.add_class').click(function() {
    //     let class_name = $(this).siblings('input[name=class]').val();
    //     if (isEmpty(class_name)) {
    //         renderStatus('danger', '请输入班级名称!');
    //         return;
    //     }
    //     let li_item_dom = '<li class="list-group-item">\
    //         <div class="form-inline">\
    //             <input type="text" class="form-control" name="class" value="' + class_name + '" readonly>\
    //             <button class="btn btn-danger delete_class"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>\
    //         </div>\
    //     </li>';
    //     addClass(li_item_dom, '#add_class_li');
    //     renderStatus('success', '添加成功，请保存！');
    //     initAddClasseInput();
    // });
    //添加unit
    $('.add_unit').click(function() {
        let unit_name = $(this).siblings('input[name=unit]').val();
        let unit_place = $(this).siblings('input[name=unit_place]').val();
        if (isEmpty(unit_name)) {
            renderStatus('danger', '请输入课程名称!');
            return;
        }
        if (isEmpty(unit_place)) {
            renderStatus('danger', '请输入上课地点！');
            return;
        }
        let li_item_dom = '<li class="list-group-item unit">\
            <div class="form-inline">\
                <input type="text" class="form-control" name="unit" value="' + unit_name + '" readonly>\
                <input type="text" class="form-control" name="unit_place" value="' + unit_place + '" readonly>\
                <button class="btn btn-danger delete_unit"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>\
            </div>\
        </li>';
        addClass(li_item_dom, '#add_unit_li');
        $('.delete_unit').click(function() {
            $(this).parents('li').remove();
        });
        renderStatus('success', '添加成功，请保存！');
        initAddUnitInput();
    });

    // //删除classes
    // $('.delete_class').click(function() {
    //     $(this).parents('li').remove();
    // });
    //删除unit
    $('.delete_unit').click(function() {
        $(this).parents('li').remove();
    });

    //获取classes,units
    $('#setting_form_submit_button').click(function(e) {
        e.preventDefault();
        //addUserInfo('#setting_form');
        //let classes_str = getClasses();
        //$('<input type="text" name="classes" value="' + classes_str + '" hidden>').appendTo('#setting_form');
        let units_arr = getUnits();
        for (var i = 0; i < units_arr.length; i++) {
            $('<input type="text" name="units[]" value="' + units_arr[i]['name'] + ':' + units_arr[i]['place'] + '" hidden>').appendTo('#setting_form');
        }
        $('#setting_form').trigger('submit');
    });
});

function getManagers()
{
    let managers = [];
    $('.manager').each(function(index) {
        if ($(this).find('.add_manager').length < 1) {
            let manager_name = $(this).find('.manager_name').attr('value');
            let manager_pwd = $(this).find('.manager_pwd').attr('value');
            managers[index] = {'manager_name' : manager_name, 'manager_pwd' : manager_pwd};
        }
    });
    return managers;
}

function isEmpty(str)
{
    if (!isString(str)) {
        return false;
    }
    return !str.trim();
}

function renderStatus(status, msg)
{
    if(status == 'danger') {
        $('.success_status').hide();
        $('.danger_status').text(msg).show();
    } else {
        $('.danger_status').hide();
        $('.success_status').text(msg).show();
    }
}

function isString(str){
    if(typeof str=="string"){
        return true;
    }else{
        return false;
    }
}

function addUserInfo(obj_str)
{
    $(obj_str + '>input[name="name"]').remove();
    $(obj_str + '>input[name="pwd"]').remove();
    $('<input type="text" name="name" value="' + $('#username').val() + '" hidden="hidden">').appendTo(obj_str);
    $('<input type="text" name="pwd" value="' + $('#pwd').val() + '" hidden="hidden">').appendTo(obj_str);
}

function addClass(dom, obj_str)
{
    $(obj_str).before(dom);
}

function initAddClasseInput()
{
    $('#add_class_li').find('input').val('');
}

function initAddUnitInput()
{
    $('#add_unit_li').find('input').val('');
}

function getClasses()
{
    let classes_str = '';
    $('.class').each(function() {
        if( $(this).find('.add_class').length < 1) {
            classes_str += $(this).find('input').attr('value') + '+';
        }
    });
    return classes_str;
}

function getUnits()
{
    let units_arr = [];
    $('.unit').each(function(index) {
        if( $(this).find('.add_unit').length < 1) {
            units_arr[index] = {};
            units_arr[index]['name'] = $(this).find('input[name=unit]').val();
            units_arr[index]['place'] = $(this).find('input[name=unit_place]').val();
        }
    });
    return units_arr;
}
