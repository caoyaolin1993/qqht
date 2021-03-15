<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="description" content="eleTree扩展树示例" />
    <meta name="keywords" content="eleTree示例,layui扩展,hsiangleev" />
    <title>layui扩展树示例</title>
    <link rel="stylesheet" href="/static/plugins/eletree/layui/css/layui.css" media="all" />
    <link rel="stylesheet" href="/static/plugins/eletree/eleTree/eleTree.css" media="all" />
</head>

<body>
    @csrf
    <input type="hidden" name="id" value="{{$id}}">
    <input type="hidden" name="keys" value="{{$group}}">
    <div style="padding: 20px;">
        <div class="ele2" lay-filter="data2">
        </div>
        <button id="tj">提交</button>
    </div>
    <script src="/static/plugins/eletree/layui/layui.js"></script>
    <script>
        layui.config({
            base: "/static/plugins/eletree/layui/lay/mymodules/",
        }).use(
            ["jquery", "table", "eleTree", "code", "form", "slider", "layer"],
            function() {
                var $ = layui.jquery;
                var eleTree = layui.eleTree;
                var table = layui.table;
                var code = layui.code;
                var form = layui.form;
                var slider = layui.slider;
                var layer = layui.layer;

                var id = $.trim($('input[name="id"').val());
                var keysa = $.trim($('input[name="keys"').val());
                var keys = keysa.split(',');

                var el2 = eleTree.render({
                    elem: ".ele2",
                    url: "/admins/role/setroledata/?id=" + id,
                    showCheckbox: true,
                    defaultExpandAll: true,
                    defaultCheckedKeys: keys,

                    done: function() {

                    },
                });
                $('#tj').click(function() {
                    data = el2.getChecked(false, false);
                    var _token = $.trim($('input[name="_token"').val());
                    var arr = [];
                    for (let key in data) {
                        arr.push(Object.values(data[key])[0]);
                    }
                    $.post('/admins/role/roletj', {
                        data: arr,
                        _token: _token,
                        id: id
                    }, function(res) {
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
                });
            }
        );
    </script>
</body>

</html>