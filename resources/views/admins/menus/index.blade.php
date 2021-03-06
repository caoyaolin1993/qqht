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
            <div class="layui-btn-container"><button class="layui-btn layui-btn-sm" lay-event="ADD">增加</button></div>
        </script>
        <script type="text/html" id="switchTpl">
            <input type="checkbox" name="sex" value="@{{d.id}}" lay-skin="switch" lay-text="启用|禁用" lay-filter="sexDemo" @{{ d.status == 0 ? 'checked' : '' }}>
        </script>
        <script type="text/html" id="switchTpla">
            <input type="checkbox" name="sex" value="@{{d.id}}" lay-skin="switch" lay-text="正常|隐藏" lay-filter="sexDemoa" @{{ d.ishidden == 0 ? 'checked' : '' }}>
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
                limit: 50,
                skin: 'nob',
                even: 'true',
                cols: [
                    [{
                        field: 'id',
                        title: 'ID',
                        width: 80,
                        sort: true,
                        fixed: 'left',
                    }, {
                        field: 'title',
                        title: '菜单名称',
                        sort: true,
                        edit: 'text',
                        style: 'background-color: LightGrey; color: #fff;'
                    }, {
                        field: 'controller',
                        edit: 'text',
                        sort: true,
                        title: 'controller'
                    }, {
                        field: 'action',
                        title: 'action',
                        sort: true,
                        edit: 'text',
                    }, {
                        field: 'ishidden',
                        title: '是否隐藏',
                        templet: '#switchTpla'
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
                    case 'ADD':
                        layer.open({
                            id: '',
                            type: 2,
                            title: '增加',
                            anim: 1,
                            area: ['800px', '450px'],
                            content: '/admins/menus/add'
                        });
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
                $.get('/admin/menus/editField', {
                    type: field,
                    id: data.id,
                    value: value
                }, function(res) {
                    if (res.code > 0) {
                        return layer.alert(res.msg, {
                            icon: 2
                        });
                    }
                }, 'json');
            });

            form.on('switch(sexDemo)', function(obj) {
                console.log(obj);
                var status = '';
                if (obj.elem.checked == false) {
                    status = 1;
                } else {
                    status = 0;
                }
                $.get('/admins/menus/upstatus', {
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
            form.on('switch(sexDemoa)', function(obj) {
                console.log(obj);
                var ishidden = '';
                if (obj.elem.checked == false) {
                    ishidden = 1;
                } else {
                    ishidden = 0;
                }
                $.get('/admins/menus/upishidden', {
                    id: obj.value,
                    ishidden: ishidden
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
                        content: '/admins/menus/detail?id=' + data.id
                    });


                } else if (layEvent === 'del') {

                    layer.confirm('真的删除行么', function(index) {

                        console.log(data);

                        $.get('/admins/menus/del', {
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
                        title: '编辑',
                        anim: 1,
                        area: ['800px', '580px'],
                        content: '/admins/menus/edit?id='+data.id
                    });
                } else if (layEvent === 'LAYTABLE_TIPS') {
                    layer.alert('Hi，头部工具栏扩展的右侧图标。');
                } else if (layEvent === 'edittitle') {
                    console.log(data);
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
       <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a><a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
    </script>
</body>
</html>