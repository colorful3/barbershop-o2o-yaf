/**
 * Created by Colorful on 2018/5/14.
 * 登录校验js
 */
;
var login_ops = {
    init:function() {
        this.eventBind();
    },
    eventBind:function() {
        $("#login_btn").click(function() {
            // 设置按钮点击标记，防止重复提交
            var btn_target = $(this);
            if( btn_target.hasClass('disabled') ) {
                layer.alert('处理中，请勿重复提交！');
            }
            var username = $("#username").val();
            var password = $("#password").val();

            // 校验数据
            if( !username ) {
                layer.tips('请输入用户名', $("#username"),{
                    tips: [ 3, '#e5004f']
                });
                return;
            }

            if( !password ) {
                layer.tips('请输入密码', $("#password"), {
                    tips: [ 3, '#e5004f']
                });
                return;
            }


            // 添加按钮标记
            btn_target.addClass("disabled");

            // 向后台抛送ajax数据
            var tar_url = common_ops.buildUrl('/admin/login/index');
            var data = {
                'username': username,
                'password': password,
            };
            $.ajax({
                url: tar_url,
                type: 'post',
                data: data,
                dataType: 'json',
                success: function( rep ) {
                    btn_target.removeClass("disabled");
                    if( rep.errno != 0 ) {
                        layer.msg(rep.errmsg, {icon: 2});
                        return false;
                    } else {
                        layer.msg('登录成功,正在跳转...',{icon: 1});
                        var red_url = common_ops.buildUrl('/admin/index/index');
                        setTimeout( function () {
                            window.location.href = red_url
                        }, 2000);
                    }
                    // console.log(rep);
                }
            })


        })
    }
};

$(document).ready( function() {
   login_ops.init();
});