<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登录</title>
    <link rel="stylesheet" href="/static/plugins/layui/css/layui.css">
    <script src="/static/plugins/layui/layui.js"></script>
</head>
<body style="background: #1E9FFF;" class="layui-layout-body">
    <div class="layui-container">
        @csrf
        <div class="layui-row" style="margin-top: 280px;">
            <div class="layui-col-md6 layui-col-md-offset3" style="background: #fff;border-radius: 4px;">
                <div style="padding-right: 30px;padding-top: 20px;padding-bottom: 40px;box-shadow: 5px 5px 20px #333;">
                    <div class="layui-form-item" style="padding-left: 10px;">
                        <h2 style="color: #333;">通用后台管理系统</h2>
                    </div>
                    <hr>
                    <div class="layui-form-item">
                        <label class="layui-form-label">用户名</label>
                        <div class="layui-input-inline">
                            <input type="text" name="username" placeholder="请输入标题" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">密码框</label>
                        <div class="layui-input-inline">
                            <input type="password" name="pwd" placeholder="请输入密码" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">验证码</label>
                        <div class="layui-input-inline">
                            <input type="text" name="captcha" autocomplete="off" class="layui-input" onkeydown="hc()">
                        </div>
                        <img src="/admins/account/captcha" onclick="gb(this)" alt="" style="border: 1px solid #cdcdcd;width:120px;height:35px">
                    </div>
                    <div style="margin-left: 110px;" class="layui-form-block">
                        <button type="button" class="layui-btn" onclick="dologin()">登录</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<script>
    layui.use(['layer'], function() {
        $ = layui.jquery;
        layer = layui.layer;
    });
    function dologin() {
        var username = $.trim($('input[name="username"').val());
        var pwd = $.trim($('input[name="pwd"').val());
        var captcha = $.trim($('input[name="captcha"').val());
        var _token = $.trim($('input[name="_token"').val());
        if (username == '') {
            return layer.alert('请输入用户名', {icon: 2});
        }
        if (pwd=='') {
            return layer.alert('请输入密码', {icon: 2});
        }
        if (captcha == '') {
            return layer.alert('请输入验证码', {icon: 2});
        }
        $.post('/admins/account/dologin',{username:username,pwd:pwd,captcha:captcha,_token:_token},function(res) {
            if (res.code>0) {
                return layer.alert(res.msg, {icon: 2});
            }
            layer.msg(res.msg);
            // 一秒以后跳转到后台主页
            setTimeout(function () {window.location.href='/admins/home/index'},1000);
        },'json');
    }
    function gb(obj) {
        $(obj).attr('src','/admins/account/captcha');
    }

    function hc() {
        if (event.keyCode == 13) {
            dologin();
        }
    }
</script>