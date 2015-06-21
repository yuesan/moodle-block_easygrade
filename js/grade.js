$("#save_all").click(function () {
    var is_error = false;

    $(".input_grade").each(function () {
        var grade = $(this).val();
        var userid = $(this).attr("userid");
        var courseid = $(this).attr("courseid");
        var cmid = $(this).attr("cmid");

        $.ajax({
            type: "POST",
            url: "ajax_grade.php",
            data: {
                "grade": grade,
                "userid": userid,
                "courseid": courseid,
                "cmid": cmid,
                "mode" : "updategrade"
            },
            success : function(e){
                var val = $.parseJSON(e);
                if(val.result == "success"){
                    console.log(val);
                    is_error = false;
                }else{
                    is_error = true;
                }
            },
            error : function(){
                is_error = true;
            }
        });
    });
    if(is_error == false){
        alert("評点の保存に成功しました");
    }else{
        alert("保存に失敗しました");
    }
});

$("#set_maxgrade").click(function () {
    $(".input_grade").each(function () {
        $(this).val(100);
    });
});