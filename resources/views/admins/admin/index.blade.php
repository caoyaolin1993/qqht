<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理员列表</title>
    <link rel="stylesheet" href="/static/plugins/layui/css/layui.css">
    <script src="/static/plugins/layui/layui.js"></script>
</head>

<body>
    <div class="demoTable" style="margin-top: 10px;margin-left: 20px;margin-right: 20px;"> 搜索ID：<div class="layui-inline"><input class="layui-input" name="id" id="demoReload" autocomplete="off"></div> &nbsp; 搜索用户名：<div class="layui-inline"><input class="layui-input" name="username" id="demoReload1" autocomplete="off"></div><button class="layui-btn" data-type="reload">搜索</button></div>
    <div style="margin-left: 20px;margin-right: 20px;">
        <table id="demo" lay-filter="test"></table>
        <script type="text/html" id="toolbarDemo">
            <div class="layui-btn-container"><button class="layui-btn layui-btn-sm" lay-event="ADD">增加</button><button class="layui-btn layui-btn-sm" lay-event="getCheckData">获取选中行数据</button><button class="layui-btn layui-btn-sm" lay-event="getCheckLength">获取选中数目</button><button class="layui-btn layui-btn-sm" lay-event="isAll">验证是否全选</button></div>
        </script>
        <script type="text/html" id="switchTpl">
            <input type="checkbox" name="sex" value="@{{d.id}}" lay-skin="switch" lay-text="正常|禁用" lay-filter="sexDemo" @{{ d.status == 0 ? 'checked' : '' }}>
        </script>
        <script type="text/html" id="switchTpl1">
            @{{ d.add_time > 0 ? formatDateTime(d.add_time):''}}
        </script>
        <script type="text/html" id="switchTpl2">
            @{{ d.login_time > 0 ? formatDateTime(d.login_time):''}}
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
                url: '/admins/admin/indexdata',
                id: 'testReload',
                page: false,
                cols: [
                    [{
                        fixed: 'left',
                        type: 'checkbox',
                        event: 'ch'
                    }, {
                        field: 'id',
                        title: 'ID',
                        width: 80,
                        sort: true,
                        fixed: 'left',
                    }, {
                        field: 'username',
                        title: '用户名'
                    }, {
                        field: 'realname',
                        title: '真实姓名'
                    }, {
                        field: 'gid',
                        title: '角色'
                    }, {
                        field: 'last_login',
                        title: '最后登录时间',
                        templet: '#switchTpl2'
                    }, {
                        field: 'add_time',
                        title: '添加时间',
                        templet: '#switchTpl1'
                    }, {
                        field: 'status',
                        title: '状态',
                        templet: '#switchTpl'
                    }, {
                        fixed: 'right',
                        title: '操作',
                        width: 180,
                        align: 'center',
                        toolbar: '#barDemo'
                    }]
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
                    case 'ADD':
                        layer.open({
                            id: '',
                            type: 2,
                            title: '查看',
                            anim: 1,
                            area: ['800px', '430px'],
                            content: '/admins/admin/add'
                        });
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
                console.log(obj);
                var status = '';
                if (obj.elem.checked == false) {
                    status = 1;
                } else {
                    status = 0;
                }

                $.get('/admins/admin/upstatus', {
                    id: obj.value,
                    status: status
                }, function(res) {
                    if (res.code > 0) {
                        return layer.alert(res.msg, {
                            icon: 2
                        });
                    }
                }, 'json');

            });
            table.on('tool(test)', function(obj) {
                var data = obj.data;
                var layEvent = obj.event;
                var tr = obj.tr;
                if (layEvent === 'detail') {
                    layer.open({
                        id: '',
                        type: 2,
                        title: '查看',
                        anim: 1,
                        area: ['800px', '430px'],
                        content: '/admins/admin/detail?aid=' + data.id
                    });
                } else if (layEvent === 'del') {
                    console.log(obj);
                    layer.confirm('真的删除行么', function(index) {
                        $.get('/admins/admin/del', {
                            id: data.id
                        }, function(res) {
                            if (res.code > 0) {
                                return layer.alert(res.msg, {
                                    icon: 2
                                });
                            }
                            obj.del();
                            layer.close(index);
                            layer.msg(res.msg);
                        }, 'json');
                    });
                } else if (layEvent === 'edit') {
                    layer.open({
                        id: '',
                        type: 2,
                        title: '修改管理员',
                        anim: 1,
                        area: ['800px', '430px'],
                        content: '/admins/admin/edit?aid=' + data.id
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

        function formatDateTime(inputTime) {
            var date = new Date(inputTime * 1000);
            var y = date.getFullYear();
            var m = date.getMonth() + 1;
            m = m < 10 ? ('0' + m) : m;
            var d = date.getDate();
            d = d < 10 ? ('0' + d) : d;
            var h = date.getHours();
            h = h < 10 ? ('0' + h) : h;
            var minute = date.getMinutes();
            var second = date.getSeconds();
            minute = minute < 10 ? ('0' + minute) : minute;
            second = second < 10 ? ('0' + second) : second;
            return y + '-' + m + '-' + d + ' ' + h + ':' + minute + ':' + second;
        };
    </script>
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-xs" lay-event="detail">查看</a><a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a><a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>
</body>

</html>