$(function() {
    $("#main_area .course_item").click(function() {
        if(!$(this).hasClass("has_choosed")) {
            if(!$(this).hasClass("choosed")) {
                $(this).addClass("choosed");
            } else {
                $(this).removeClass("choosed");
            }
        }
    });

    $('#unit').change(function() {
        $('#unit > option:selected').each(function() {
            $("#" + $(this).text().replace(/\s/g, '_')).show();
        });
        $('#unit > option:not(:selected)').each(function() {
            if (!!$(this).text()) {
                $("#" + $(this).text().replace(/\s/g, '_')).hide();
            }
        });
    }).trigger('change');

    $("#course_form_submit_button").click(function(event) {
        event.preventDefault();
        if ($("#main_area .choosed").length < 1) {
            alert("请在课程安排中选择上课时间！！！");
        } else {
            var course_choosed_result  = "";
            $('#unit > option').each(function() {
                if(!!$(this).text() && $("#" + $(this).text().replace(/\s/g, '_') + " .choosed").length > 0) {
                    course_choosed_result += "+" + $(this).text() + "-";
                    $("#" + $(this).text().replace(/\s/g, '_') + " .choosed").each(function() {
                        course_choosed_result += $(this).attr('value') + "&";
                    });
                }
            })
            $('#course_choosed_result').attr('value', course_choosed_result);
            $("#choose_course_form").trigger('submit');
        }
    });
});
