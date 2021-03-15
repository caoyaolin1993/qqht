<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/static/plugins/layui/css/layui.css">
    <script src="/static/plugins/layui/layui.js"></script>
</head>

<body>
    <div style="padding: 10px;">
        <form class="layui-form layui-form-pane" action="" style="margin-top: 10px;" lay-filter="aaaa">
            @csrf
            <div class="layui-form-item"><label class="layui-form-label">菜单名称</label>
                <div class="layui-input-inline" style="width: 600px;"><input type="text" name="title" required lay-verify="required" placeholder="请输入菜单名称" autocomplete="off" class="layui-input"></div>
            </div>
            <div class="layui-form-item"><label class="layui-form-label">父级菜单</label>
                <div class="layui-input-inline" style="width: 600px;"><select name="pid" lay-verify="required">
                        <option value="0"></option>
                        @foreach($menus as $menu)
                        <option value="{{$menu['id']}}">{{$menu['title']}}</option>
                        @endforeach
                    </select></div>
            </div>
            <div class="layui-form-item"><label class="layui-form-label">controller</label>
                <div class="layui-input-inline" style="width: 600px;"><input type="text" name="controller" required lay-verify="required" placeholder="请输入controller" autocomplete="off" class="layui-input"></div>
            </div>
            <div class="layui-form-item"><label class="layui-form-label">action</label>
                <div class="layui-input-inline" style="width: 600px;"><input type="text" name="action" required lay-verify="" placeholder="请输入action" autocomplete="off" class="layui-input"></div>
            </div>
            <div class="layui-form-item"><label class="layui-form-label">是否隐藏</label>
                <div class="layui-input-inline" style="width: 600px;"><input type="checkbox" name="ishidden" title="隐藏" lay-skin="primary"></div>
            </div>
            <div class="layui-form-item"><label class="layui-form-label">状态</label>
                <div class="layui-input-inline" style="width: 600px;"><input type="checkbox" name="status" title="禁用" lay-skin="primary"></div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block"><button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button><button type="reset" class="layui-btn layui-btn-primary">重置</button></div>
            </div>
        </form>
    </div>
    <script>
        layui.use('form', function() {
            var form = layui.form;
            $ = layui.jquery;
            form.on('submit(formDemo)', function(data) {
                if (data.field.ishidden == 'on') {
                    data.field.ishidden = 1;
                } else {
                    data.field.ishidden = 0;
                }

                if (data.field.status == 'on') {
                    data.field.status = 1;
                } else {
                    data.field.status = 0;
                }

                $.post('/admins/menus/add', data.field, function(res) {
                    if (res.code > 0) {
                        return layer.alert(res.msg, {
                            icon: 2
                        });
                    }
                    layer.msg(res.msg);
                    setTimeout(function() {
                        parent.window.location.reload()
                    }, 1000);
                }, 'json');

                return false;
            });
        });
    </script>
</body>

</html>