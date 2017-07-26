$(function() {
    //初始化course_item course属性

    $("#units_table .course_item").click(function() {
        let current_unit = $.trim($('#unit option:selected').text());
        let current_unit_code = $.trim($('#unit option:selected').val());
        let current_unit_place = $.trim($('#unit option:selected').attr('place'));
        if(!$(this).hasClass("choosed")) {
            $(this).addClass("choosed");
            $(this).attr('course', current_unit_code);
            $(this).text(current_unit + '@' + current_unit_place);
        } else if($(this).attr('course') == current_unit_code) {
            $(this).removeClass("choosed");
            $(this).text('');
            $(this).attr('course', '');
        } else {
            alert("这节课已选!!!");
        }
    });

    $('#unit').change(function() {
        $('#unit > option:selected').each(function() {
            $("#" + $(this).val()).show();
        });
        $('#unit > option:not(:selected)').each(function() {
            if (!!$(this).text()) {
                $("#" + $(this).val()).hide();
            }
        });
    }).trigger('change');

    $("#course_form_submit_button").click(function(event) {
        event.preventDefault();
        var course_choosed_result  = "";
        var can_submit = true;
        $('#unit > option').each(function() {
            let current_unit_code = $(this).val();
            course_choosed_result += "+" + current_unit_code + "-";
            var obj_id = "#" + current_unit_code;
            let units_table = $('#units_table');
            let current_unit_choosed_obj = units_table.find("[course=" + current_unit_code + "]");
            if(!!$(this).text() && current_unit_choosed_obj.length > 0) {
                current_unit_choosed_obj.each(function() {
                    course_choosed_result += $(this).attr('value') + "&";
                });
            }
            var start_time = $(obj_id + " [name=start_time]").val();
            var end_time = $(obj_id + " [name=end_time]").val();
            if ($.isEmptyObject(start_time) || $.isEmptyObject(end_time)) {
                alert("请选择课程开始时间和结束时间");
                can_submit = false;
                return false;
            } else {
                course_choosed_result += ":" + start_time.replace(/-/g, '_') + "*" + end_time.replace(/-/g, '_');
            }
        });
        $('#course_choosed_result').attr('value', course_choosed_result);
        console.log(course_choosed_result);
        if (can_submit) {
            $("#choose_course_form").trigger('submit');
        }
    });
});
