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
    <form class="layui-form" action="" style="margin-top: 40px;" lay-filter="aaaa">
        @csrf
        <input type="hidden" name="aid" value="{{$item['id']}}">
        <div class="layui-form-item"><label class="layui-form-label">用户名</label>
            <div class="layui-input-inline" style="width: 600px;"><input readonly value="{{$item['username']}}" type="text" name="username" required lay-verify="required" placeholder="请输入用户名" autocomplete="off" class="layui-input"></div>
        </div>
        <div class="layui-form-item"><label class="layui-form-label">密码</label>
            <div class="layui-input-inline" style="width: 600px;"><input type="password" name="password" required lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input"></div>
        </div>
        <div class="layui-form-item"><label class="layui-form-label">真实姓名</label>
            <div class="layui-input-inline" style="width: 600px;"><input value="{{$item['realname']}}" type="text" name="realname" required lay-verify="required" placeholder="请输入真实姓名" autocomplete="off" class="layui-input"></div>
        </div>
        <div class="layui-form-item"><label class="layui-form-label">角色</label>
            <div class="layui-input-inline" style="width: 600px;"><select name="gid" lay-verify="required">
                    @foreach($groups as $group)
                    <option {{$item['gid']==$group['id']?'selected':'' }} value="{{$group['id']}}">{{$group['title']}}</option>
                    @endforeach
                </select></div>
        </div>
        <div class="layui-form-item"><label class="layui-form-label">状态</label>
            <div class="layui-input-inline" style="width: 600px;">
                <input {{$item['status'] == 1?'checked':'' }} type="checkbox" name="status" title="禁用" lay-skin="primary">
            </div>
        </div>
        <div class="layui-form-item" style="padding-top: 20px;">
            <div class="layui-input-block"><button class="layui-btn" lay-submit lay-filter="formDemo">保存</button><button type="reset" class="layui-btn layui-btn-primary">重置</button></div>
        </div>
    </form>
    <script>
        layui.use('form', function() {
            var form = layui.form;
            $ = layui.jquery;
            form.on('submit(formDemo)', function(data) {
                console.log(data);
                $.post('/admins/admin/edit', data.field, function(res) {
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