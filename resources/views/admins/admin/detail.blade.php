<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>查看管理员</title>
    <link rel="stylesheet" href="/static/plugins/layui/css/layui.css">
    <script src="/static/plugins/layui/layui.js"></script>
</head>

<body>

    <div class="layui-container">
        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
            <legend>管理员信息</legend>
        </fieldset>

        <div class="layui-row">
            <div class="layui-col-xs2">
                <div class="grid-demo grid-demo-bg1">用户名：</div>
            </div>
            <div class="layui-col-xs10">
                <div class="grid-demo">{{$username}}</div>
            </div>
        </div>

        <div class="layui-row" style="padding-top: 10px;">
            <div class="layui-col-xs2">
                <div class="grid-demo grid-demo-bg1">真实姓名：</div>
            </div>
            <div class="layui-col-xs10">
                <div class="grid-demo">{{$realname}}</div>
            </div>
        </div>

        <div class="layui-row" style="padding-top: 10px;">
            <div class="layui-col-xs2">
                <div class="grid-demo grid-demo-bg1">状态：</div>
            </div>
            <div class="layui-col-xs10">
                <div class="grid-demo">{{$status == 0?'正常':'禁用' }}</div>
            </div>
        </div>

        <div class="layui-row" style="padding-top: 10px;">
            <div class="layui-col-xs2">
                <div class="grid-demo grid-demo-bg1">最后登录时间：</div>
            </div>
            <div class="layui-col-xs10">
                <div class="grid-demo">{{$last_login?date('Y-m-d H:i:s',$last_login):'' }}</div>
            </div>
        </div>

        <div class="layui-row" style="padding-top: 10px;">
            <div class="layui-col-xs2">
                <div class="grid-demo grid-demo-bg1">添加时间：</div>
            </div>
            <div class="layui-col-xs10">
                <div class="grid-demo">{{$add_time?date('Y-m-d H:i:s',$add_time):'' }}</div>
            </div>
        </div>
       
    </div>
</body>

</html>