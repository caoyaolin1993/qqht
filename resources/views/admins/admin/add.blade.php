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
    <form class="layui-form" action="" style="margin-top: 10px;" lay-filter="aaaa">
        <div class="layui-form-item"><label class="layui-form-label">输入框</label>
            <div class="layui-input-inline" style="width: 600px;"><input type="text" name="title" required lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input"></div>
        </div>
        <div class="layui-form-item"><label class="layui-form-label">密码框</label>
            <div class="layui-input-inline" style="width: 600px;"><input type="password" name="password" required lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input"></div>
            <div class="layui-form-mid layui-word-aux">辅助文字</div>
        </div>
        <div class="layui-form-item"><label class="layui-form-label">选择框</label>
            <div class="layui-input-inline" style="width: 600px;"><select name="city" lay-verify="required">
                    <option value=""></option>
                    <option value="0">北京</option>
                    <option value="1">上海</option>
                    <option value="2">广州</option>
                    <option value="3">深圳</option>
                    <option value="4">杭州</option>
                </select></div>
        </div>
        <div class="layui-form-item"><label class="layui-form-label">复选框</label>
            <div class="layui-input-inline" style="width: 600px;"><input type="checkbox" name="like[write]" title="写作"><input type="checkbox" name="like[read]" title="阅读" checked><input type="checkbox" name="like[dai]" title="发呆"></div>
        </div>
        <div class="layui-form-item"><label class="layui-form-label">开关</label>
            <div class="layui-input-inline" style="width: 600px;"><input type="checkbox" name="switch" lay-skin="switch"></div>
        </div>
        <div class="layui-form-item"><label class="layui-form-label">单选框</label>
            <div class="layui-input-inline" style="width: 600px;"><input type="radio" name="sex" value="男" title="男"><input type="radio" name="sex" value="女" title="女" checked></div>
        </div>
        <div class="layui-form-item layui-form-text"><label class="layui-form-label">文本域</label>
            <div class="layui-input-inline" style="width: 600px;"><textarea name="desc" placeholder="请输入内容" class="layui-textarea"></textarea></div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block"><button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button><button type="reset" class="layui-btn layui-btn-primary">重置</button></div>
        </div>
    </form>
    <script>
        layui.use('form', function() {
            var form = layui.form;
            form.on('submit(formDemo)', function(data) {
                console.log(data);
                layer.msg(JSON.stringify(data.field));
                return false;
            });
        });
    </script>
</body>
</html>