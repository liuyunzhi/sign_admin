<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="renderer" content="webkit|ie-comp|ie-stand">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <link rel="Bookmark" href="/favicon.ico" >
        <link rel="Shortcut Icon" href="/favicon.ico" />
        <!--[if lt IE 9]>
        <script type="text/javascript" src="lib/html5shiv.js"></script>
        <script type="text/javascript" src="lib/respond.min.js"></script>
        <![endif]-->
        <link rel="stylesheet" type="text/css" href="../css/H-ui.min.css" />
        <link rel="stylesheet" type="text/css" href="../css/H-ui.admin.css" />
        <link rel="stylesheet" type="text/css" href="../lib/Hui-iconfont/1.0.8/iconfont.css" />
        <link rel="stylesheet" type="text/css" href="../skin/default/skin.css" id="skin" />
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <!--[if IE 6]>
        <script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js" ></script>
        <script>DD_belatedPNG.fix('*');</script>
        <![endif]-->
        <title>菜单列表</title>
    </head>
    <body>
        <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 权限管理 <span class="c-gray en">&gt;</span> 菜单管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
        <div class="page-container">
            <div class="cl pd-5 bg-1 bk-gray mt-20">
                <span class="l">
                    <!-- <a href="javascript:;" onclick="meun_dal()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> -->
                    <a href="javascript:;" onclick="meun_add('添加菜单','/permission/meun-add','800','500')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加菜单 </a>
                </span>
            </div>
            <div class="mt-20">
                <table class="table table-border table-bordered table-bg table-sort">
                    <thead>
                        <tr class="text-c">
                            <th width="25"><input type="checkbox" name="" value=""></th>
                            <th width="40">编号</th>
                            <th width="40">图标</th>
                            <th>菜单名称</th>
                            <th width="100">控制器</th>
                            <th width="100">动作</th>
                            <th width="100">类型</th>
                            <th width="60" class="permission_id">菜单ID</th>
                            <th width="60">父级ID</th>
                            <th width="40">状态</th>
                            <th width="140">创建时间</th>
                            <th width="140">更新时间</th>
                            <th width="60">操作</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!--_footer 作为公共模版分离出去-->
        <script type="text/javascript" src="../lib/jquery/1.9.1/jquery.min.js"></script>
        <script type="text/javascript" src="../lib/layer/2.4/layer.js"></script>
        <script type="text/javascript" src="../js/H-ui.min.js"></script>
        <script type="text/javascript" src="../js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

        <!--请在下方写此页面业务相关的脚本-->
        <script type="text/javascript" src="../lib/My97DatePicker/4.8/WdatePicker.js"></script>
        <script type="text/javascript" src="../lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="../lib/laypage/1.2/laypage.js"></script>
        <script type="text/javascript">
            var table = $('.table-sort').dataTable( {
                "paging": false,
                "searching": false,
                "ordering": false,
                "serverSide": true,
                "ajax": {
                    "url": "/permission/meuns",
                    "type": "post"
                },
                "createdRow": function( row, data, dataIndex ) {
                    $(row).addClass('text-c');
                },
                "columns": [
                    {"data": null, "render": function( data, type, row, meta ){
                        return '<input type="checkbox" value="'+row.permission_id+'" name="ids">';
                    }},
                    {"data": "order"},
                    {"data": "icon", "render": function( data, type, row, meta ){
                        if(data){
                            return "<i class='Hui-iconfont'>"+data+"</i>";
                        }else{
                            return "";
                        }
                    }},
                    {"data": "name"},
                    {"data": "controller"},
                    {"data": "action"},
                    {"data": "type", "render": function( data, type, row, meta ){
                        switch (data) {
                            case '0':
                                return "父级菜单";
                            case '1':
                                return "子菜单";
                        }
                    }},
                    {"data": "permission_id"},
                    {"data": "parent_id"},
                    {"data": "status", "render": function( data, type, row, meta ){
                        switch (data) {
                            case '0':
                                return "<span class='label radius'>已停用</span>";
                            case '1':
                                return "<span class='label label-success radius'>正常</span>";
                        }
                    }, "className": "td-status"},
                    {"data": "created_at"},
                    {"data": "updated_at"},
                    {"data": null, "render": function( data, type, row, meta ){
                            var status_button = row.status != '0' ? '<a style="text-decoration:none" onClick="meun_stop(this,'+row.permission_id+')" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe631;</i></a>' : '<a onClick="meun_start(this,'+row.permission_id+')" href="javascript:;" title="启用" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>';
                            return status_button+'<a title="编辑" href="javascript:;" onclick=meun_edit("编辑菜单","/permission/meun-edit",'+row.permission_id+',"800","500") class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>'+
                            '<a title="删除" href="javascript:;" onclick="meun_del(this,'+row.permission_id+')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>';
                    }, "className": "td-manage"}
                ]
            } );
            /*菜单-增加*/
            function meun_add(title,url,w,h){
                layer_show(title,url,w,h);
            }
            /*菜单-编辑*/
            function meun_edit(title,url,id,w,h){
                url = url+'?id='+id;
                layer_show(title,url,w,h);
            }
            /*菜单-停用*/
            function meun_stop(obj,id){
                layer.confirm('确认要停用吗？',function(index){
                    $.ajax({
                        type: 'POST',
                        url: '/permission/meun-start-stop',
                        dataType: 'json',
                        data: {'id': id,'status': 0},
                        async: false,
                        success: function(data){
                            if(data.code == 10000){
                                layer.msg('已停用!',{icon: 5,time:1000},function(){
                                    table.api().ajax.reload();
                                });
                            }else{
                                layer.msg(data.message,{icon:5});
                            }
                        },
                        error: function(data) {
                            console.log(data.message);
                        },
                    });
                });
            }
            /*菜单-启用*/
            function meun_start(obj,id){
                layer.confirm('确认要启用吗？',function(index){
                    $.ajax({
                        type: 'POST',
                        url: '/permission/meun-start-stop',
                        dataType: 'json',
                        data: {'id': id,'status': 1},
                        async: false,
                        success: function(data){
                            if(data.code == 10000){
                                layer.msg('已启用!', {icon: 6,time:1000},function(){
                                    table.api().ajax.reload();
                                });
                            }else{
                                layer.msg(data.message,{icon:5});
                            }
                        },
                        error: function(data) {
                            console.log(data.message);
                        },
                    });
                });
            }
            /*菜单-删除*/
            function meun_del(obj,id){
                layer.confirm('确认要删除吗？',function(index){
                    $.ajax({
                        type: 'GET',
                        url: '/permission/meun-delete',
                        dataType: 'json',
                        data: {'id':id},
                        async: false,
                        success: function(data){
                            if(data.code == 10000){
                                $(obj).parents("tr").remove();
                                layer.msg('已删除!',{icon:1,time:1000});
                                table.api().ajax.reload();
                            }else{
                                layer.msg(data.message,{icon:5});
                            }
                        },
                        error: function(data) {
                            console.log(data.message);
                        },
                    });
                });
            }
        </script>
    </body>
</html>