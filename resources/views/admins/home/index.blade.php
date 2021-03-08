<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>首页</title>
    <link rel="stylesheet" href="/static/plugins/layui/css/layui.css">
    <script src="/static/plugins/layui/layui.js"></script>
</head>

<body class="layui-layout-body">
    <div class="layui-layout layui-layout-admin">
        <div class="layui-header">
            <div class="layui-logo">通用后台管理系统</div>
            <!-- 头部区域（可配合layui已有的水平导航） -->
            <ul class="layui-nav layui-layout-left">
                <li class="layui-nav-item"><a href="">控制台</a></li>
                <li class="layui-nav-item"><a href="">商品管理</a></li>
                <li class="layui-nav-item"><a href="">用户</a></li>
                <li class="layui-nav-item">
                    <a href="javascript:;">其它系统</a>
                    <dl class="layui-nav-child">
                        <dd><a href="">邮件管理</a></dd>
                        <dd><a href="">消息管理</a></dd>
                        <dd><a href="">授权管理</a></dd>
                    </dl>
                </li>
            </ul>
            <ul class="layui-nav layui-layout-right">
                <li class="layui-nav-item">
                    <a href="javascript:;">
                        <img src="http://t.cn/RCzsdCq" class="layui-nav-img">
                        admin[{{$admin->group_title}}]
                    </a>
                    <dl class="layui-nav-child">
                        <dd><a href="">基本资料</a></dd>
                        <dd><a href="">安全设置</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item"><a href="javascript:;" onclick="logout()">退出</a></li>
            </ul>
        </div>

        <div class="layui-side layui-bg-black">
            <div class="layui-side-scroll">
                <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
                <ul class="layui-nav layui-nav-tree">
                    @foreach($menus as $key => $menu)
                    <li class="layui-nav-item {{$key==0?'layui-nav-itemed':''}}">
                        <a class="" href="javascript:;">{{$menu->title}}</a>
                        @if(isset($menu->childs))
                        <dl class="layui-nav-child">
                            @foreach($menu->childs as $k => $chd)
                            <dd><a href="javascript:;" onclick="firemenu(this)" controller="{{$chd->controller}}" action="{{$chd->action}}">{{$chd->title}}</a></dd>
                            @endforeach
                        </dl>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <!--  -->
        <div class="layui-body">
            <!-- 内容主体区域 -->
            <iframe src="/admins/home/welcome" frameborder="0" style="width: 100%;height: calc(100% - 3px);"></iframe>
        </div>

        <div class="layui-footer">
            <!-- 底部固定区域 -->
            © layui.com - 底部固定区域
        </div>
    </div>
    <script>
        //JavaScript代码区域
        layui.use(['element','layer'], function() {
            var element = layui.element;
            $ = layui.jquery;
            var layer =layui.layer;
        });

        function firemenu(obj) {
            var controller = $(obj).attr('controller');
            var action = $(obj).attr('action');
            var url = '/admins/' + controller.toLowerCase() + '/' + action.toLowerCase();

            $('iframe').attr('src', url);
        }

        function logout() {
            layer.confirm('确定要退出登录吗', {
                icon:3,
                btn: ['确定', '取消']
            }, function() {
                $.get('/admins/account/logout', {}, function(res) {
                   
                    if (res.code > 0 ) {
                        return layer.alert(res.msg, {icon: 2});
                    }
                    layer.msg(res.msg);
                    setTimeout(function () {window.location.href='/admins/account/login'},1000);
                }, 'json');
            });
        }
    </script>
</body>

</html>