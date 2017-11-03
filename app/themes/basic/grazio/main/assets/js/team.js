$(document).ready(function () {
    $(document).on("focus", '.form-control', function () {
        $(this).parent().parent().removeClass("has-error");
        $(this).parent().siblings().children(".help-block").html("");
    })
    $("#profile-form").submit(function (e) {
        var member = $(".signup-member");
        var arr = new Array();
        for (var i = 0; i < member.length; i++) {
            //验证志愿者编号
            var str = $(".signup-member").eq(i).children().children().children().children("#profile-number");
            var name = $(".signup-member").eq(i).children().children().children().children("#profile-name");
            if (!/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/.test(str.val())) {
                e.preventDefault();
                str.parent().siblings().children(".help-block").html("志愿者编号不合法！");
                str.parent().parent().removeClass("has-success");
                str.parent().parent().addClass("has-error");
            }

            //验证姓名
            if (!/\S/.test(name.val())) {
                name.parent().siblings().children(".help-block").html("姓名不能为空！");
                name.parent().parent().removeClass("has-success");
                name.parent().parent().addClass("has-error");
                e.preventDefault();

            } else {
                name.parent().siblings().children(".help-block").html("");
                name.parent().parent().removeClass("has-error");
                name.parent().parent().addClass("has-success");

            }
        }
    });
//增加成员
    $("#add").click(function () {
        var numinps = Number($(".numinps").val());
        numinps = numinps + 1;
        $(".numinps").val(numinps);
        var str = "";
        str += '<div class="signup-member">' +
            '<span class="num">' + numinps + '</span>' +
            '<span class="cut" style="cursor:pointer;float:right">×</span>' +
            '<div class="form-group col-sm-6">' +
            '<div class="form-group field-profile-number">' +
            '<label for="profile-number" class="col-sm-3 control-label">志愿者编号：</label>' +
            '<div class="col-sm-9"><input type="text" placeholder="志愿者编号" name="Profile[number][]" class="form-control" id="profile-number"></div>' +
            '<div class="col-sm-offset-2 col-sm-10"><p class="help-block help-block-error"></p>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="form-group col-sm-6">' +
            '<div class="form-group field-profile-name">' +
            '<label for="profile-name" class="col-sm-3 control-label">姓名：</label>' +
            '<div class="col-sm-9"><input type="text" placeholder="姓名" name="Profile[name][]" class="form-control" id="profile-name"></div>' +
            '<div class="col-sm-offset-2 col-sm-10"><p class="help-block help-block-error"></p>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="clearfix"></div>' +
            '<hr>' +
            '</div>';
        $(".member-signup").append(str);
    })

    $(document).on("click", '.cut', function () {
        $(this).parent().remove();
        var numinps = Number($(".numinps").val());
        numinps = numinps - 1;
        $(".numinps").val(numinps);
    })
})