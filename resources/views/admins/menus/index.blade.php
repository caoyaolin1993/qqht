<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>菜单列表</title>
    <link rel="stylesheet" href="/static/plugins/layui/css/layui.css">
    <script src="/static/plugins/layui/layui.js"></script>
</head>

<body>
    <div class="demoTable" style="margin-top: 10px;margin-left: 20px;margin-right: 20px;"> 搜索ID： <div class="layui-inline"><input class="layui-input" name="id" id="demoReload" autocomplete="off"></div> &nbsp; 搜索用户名： <div class="layui-inline"> <input class="layui-input" name="username" id="demoReload1" autocomplete="off"> </div> <button class="layui-btn" data-type="reload">搜索</button></div>
    <div style="margin-left: 20px;margin-right: 20px;">
        <table id="demo" lay-filter="test"></table>
        <script type="text/html" id="toolbarDemo">
            <div class="layui-btn-container"><button class="layui-btn layui-btn-sm" lay-event="getCheckData">增加</button></div>
        </script>
        <script type="text/html" id="switchTpl">
            <input type="checkbox" name="sex" value="@{{d.id}}" lay-skin="switch" lay-text="女|男" lay-filter="sexDemo" @{{ d.id == 5 ? 'checked' : '' }}>
        </script>
    </div>
    <script>
        layui.use('table', function() {
            var table = layui.table;
            var form = layui.form;
            table.render({
                elem: '#demo',
                height: 'full-180',
                toolbar: '#toolbarDemo',
                defaultToolbar: ['filter', 'print', 'exports'],
                url: '/admins/menus/indexdata',
                id: 'testReload',
                page: true,
                cols: [
                    [{
                        field: 'id',
                        title: 'ID',
                        width: 80,
                        sort: true,
                        fixed: 'left',
                    }, {
                        field: 'title',
                        title: '菜单名称'
                    }, {
                        field: 'controller',
                        title: 'controller'
                    }, {
                        field: 'action',
                        title: 'action'
                    }, {
                        field: 'ishidden',
                        title: '是否隐藏'
                    }, {
                        field: 'status',
                        title: '状态'
                    }, {
                        field: 'title',
                        title: '菜单名称'
                    }/* , {
                        field: 'sex',
                        title: '性别',
                        sort: true,
                        templet: '#switchTpl',
                    }, {
                        field: 'city',
                        title: '城市'
                    }, {
                        field: 'sign',
                        title: '签名',
                        width: '20%'
                    }, {
                        field: 'experience',
                        title: '积分',
                        sort: true
                    }, {
                        field: 'score',
                        title: '评分',
                        sort: true
                    }, {
                        field: 'classify',
                        title: '职业'
                    }, {
                        field: 'wealth',
                        title: '财富',
                        sort: true,
                        edit: 'text',
                        event: 'editcf',
                        style: 'background-color: #5FB878; color: #fff;'
                    }*/, {
                        fixed: 'right',
                        title: '操作',
                        width: 180,
                        align: 'center',
                        toolbar: '#barDemo'
                    } ]
                ]
            });
            table.on('toolbar(test)', function(obj) {
                var checkStatus = table.checkStatus(obj.config.id);
                switch (obj.event) {
                    case 'getCheckData':
                        var data = checkStatus.data;
                        layer.alert(JSON.stringify(data));
                        break;
                    case 'getCheckLength':
                        var data = checkStatus.data;
                        layer.msg('选中了：' + data.length + ' 个');
                        break;
                    case 'isAll':
                        layer.msg(checkStatus.isAll ? '全选' : '未全选');
                        break;
                    case 'LAYTABLE_TIPS':
                        layer.alert('这是工具栏右侧自定义的一个图标按钮');
                        break;
                };
            });
            table.on('edit(test)', function(obj) {
                var value = obj.value,
                    data = obj.data,
                    field = obj.field;
                layer.msg('[ID: ' + data.id + '] ' + field + ' 字段更改为：' + value);
            });
            form.on('switch(sexDemo)', function(obj) {
                layer.tips(this.value + ' ' + this.name + '：' + obj.elem.checked, obj.othis);
            });
            table.on('tool(test)', function(obj) {
                var data = obj.data;
                var layEvent = obj.event;
                var tr = obj.tr;
                if (layEvent === 'detail') {} else if (layEvent === 'del') {
                    console.log(obj);
                    layer.confirm('真的删除行么', function(index) {
                        obj.del();
                        layer.close(index);
                    });
                } else if (layEvent === 'edit') {
                    layer.open({
                        id: '',
                        type: 2,
                        title: '编辑',
                        anim: 1,
                        area: ['800px', '580px'],
                        content: ['/admins/admin/add']
                    });
                    obj.update({
                        username: '123',
                        title: 'xxx'
                    });
                } else if (layEvent === 'LAYTABLE_TIPS') {
                    layer.alert('Hi，头部工具栏扩展的右侧图标。');
                } else if (layEvent === 'editcf') {
                    console.log(tr);
                } else if (layEvent === 'ch') {
                    console.log(obj);
                }
            });
            var $ = layui.$,
                active = {
                    reload: function() {
                        var demoReload = $('#demoReload');
                        var demoReload1 = $('#demoReload1');
                        table.reload('testReload', {
                            page: {
                                curr: 1
                            },
                            where: {
                                key: {
                                    id: demoReload.val(),
                                    username: demoReload1.val()
                                }
                            }
                        }, 'data');
                    }
                };
            $('.demoTable .layui-btn').on('click', function() {
                var type = $(this).data('type');
                active[type] ? active[type].call(this) : '';
            });
        });
    </script>
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-xs" lay-event="detail">查看</a><a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a><a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>
</body>

</html>