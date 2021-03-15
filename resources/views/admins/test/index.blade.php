<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>测试</title>
    <link rel="stylesheet" href="/static/plugins/layui/css/layui.css">
    <script src="/static/plugins/layui/layui.js"></script>
</head>
<body>
<div class="layui-form layui-card-header layuiadmin-card-header-auto">
    <div class="layui-row">
        <div class="layui-col-md12">
            <div class="layui-inline layui-show-xs-block">
                 <select lay-filter="selectMore" id="demo-area-first" data-target="#demo-area-sec"></select>
            </div>
            <div class="layui-inline layui-show-xs-block">
                <select lay-filter="selectMore" id="demo-area-sec" data-target="#demo-area-th"></select>
            </div>
            <div class="layui-inline layui-show-xs-block">
                <select lay-filter="selectMore" id="demo-area-th"></select>
            </div>
        </div>
    </div>          
</div>
</body>
</html>

<script>
layui.config({
  base: '../../../layui_exts/' 
}).extend({
  selectMore: 'selectMore/selectMore'
}).use(['selectMore'], function(){
  setTimeout(function(){
      // 初始化
      // layui.selectMore.init(layui.$("#demo-area-first"));

      // 设置多个值
      // layui.selectMore.setAll(['130000','130200','130204']);

      // 独立设置值
      // layui.selectMore.set("#demo-area-first",'130000');
  },1500); //  此处的延迟执行 是属于任性的作者的强行写入 哈哈 随意删……
  
});
</script>