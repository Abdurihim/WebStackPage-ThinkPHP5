<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"E:\MrF\FyNavigation\public/../application/admin\view\menutype\index.html";i:1586615200;}*/ ?>
<!DOCTYPE html>
<html class="x-admin-sm">
    <head>
        <meta charset="UTF-8">
        <title>分类列表</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
        <link rel="stylesheet" href="/static/admin/css/font.css">
        <link rel="stylesheet" href="/static/admin/css/xadmin.css">
        <script src="/static/admin/lib/layui/layui.js" charset="utf-8"></script>
        <script type="text/javascript" src="/static/admin/js/xadmin.js"></script>
        <!--[if lt IE 9]>
          <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
          <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="x-nav">
          <span class="layui-breadcrumb">
            <a href="javascript:void(0);">首页</a>
            <a href="javascript:void(0);">分类管理</a>
            <a>
              <cite>分类列表</cite></a>
          </span>
          <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
            <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
        </div>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-body ">
                            <form action="/admin/user/1" class="layui-form layui-col-space5">
                                <div class="layui-inline layui-show-xs-block">
                                    <input class="layui-input"  autocomplete="off" placeholder="开始日(可空)" name="start" id="start">
                                </div>
                                <div class="layui-inline layui-show-xs-block">
                                    <input class="layui-input"  autocomplete="off" placeholder="截止日(可空)" name="end" id="end">
                                </div>
                                <div class="layui-inline layui-show-xs-block">
                                    <input type="text" name="tel"  placeholder="请输入手机号" autocomplete="off" class="layui-input">
                                </div>
                                <div class="layui-inline layui-show-xs-block">
                                    <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
                                </div>
                            </form>
                        </div>
                        <div class="layui-card-header">
                            <button class="layui-btn" onclick="xadmin.open('添加分类','/admin/menu/create.html',600,400)"><i class="layui-icon"></i>添加</button>
                        </div>
                        <div class="layui-card-body ">
                            <table class="layui-table layui-form">
                              <thead>
                                <tr>
                                  <th>ID</th>
                                  <th>分类名称</th>
                                  <th>分类图标</th>
                                  <th>排序</th>
                                  <th>状态</th>
                                  <th>添加时间</th>
                                  <th>操作</th>
                              </thead>
                              <tbody>
                                <tr>
                                  <?php foreach($list as $li): ?>
                                <tr>
                                  <td><?php echo $li['id']; ?></td>
                                  <td><?php echo $li['type_name']; ?></td>
                                  <td><?php echo $li['menu_icon']; ?></td>
                                  <td><?php echo $li['menu_order']; ?></td>
                                  <td class="td-status">
                                    <input type="checkbox" title="<?php echo $li['id']; ?>" name="switch"  lay-text="正常|停用"  <?php echo $li['status']==1?'checked':''; ?> lay-skin="switch" lay-filter="switchTest">
                                  </td>
                                  <td><?php echo $li['add_time']; ?></td>
                                  <td class="td-manage">
                                    <a title="编辑"  onclick="xadmin.open('编辑','/admin/menu/<?php echo $li["id"]; ?>/edit.html',600,400)" href="javascript:;">
                                      <i class="layui-icon">&#xe642;</i>
                                    </a>
                                    
                                    <a title="删除" onclick="member_del(this,<?php echo $li['id']; ?>)" href="javascript:;">
                                      <i class="layui-icon">&#xe640;</i>
                                    </a>
                                  </td>
                                </tr>
                                <?php endforeach; ?>
                              </tbody>
                            </table>
                        </div>
                        <div class="layui-card-body ">
                            <div class="page">
                                <?php echo $list->render(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </body>
    <script>
      layui.use(['laydate','form'], function(){
        var laydate = layui.laydate;
        var form = layui.form;
        
        //执行一个laydate实例
        laydate.render({
          elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
          elem: '#end' //指定元素
        });
      });

       /*监听开关*/
      layui.use(['form'], function(){
        var form = layui.form
        ,layer = layui.layer

        //监听开关
        form.on('switch(switchTest)', function(data){
          status = this.checked ? '1' : '0';
          $.post('/admin/menu/'+this.title+'?ajax=1',{'status':status,'_method':'put'},function(data){
            layer.msg(data.msg);
          })
        });
      });

      /*删除*/
      function member_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
          //发异步删除数据
          $.post('/admin/menu/'+id, {'_method':'DELETE'}, function(data, textStatus, xhr) {
            if (data.code==1) {
              $(obj).parents("tr").remove();
              layer.msg(data.msg,{icon:1,time:1000});
            }else{
              layer.msg(data.msg,{icon:5,time:1000});
            }
            
          },'json');
          
        });
      }
    </script>
</html>