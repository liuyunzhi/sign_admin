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
    </head>
    <body>
        <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 权限管理 <span class="c-gray en">&gt;</span> 用户管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
        <div class="page-container">
            <div class="text-c">
                <input type="text" class="input-text" style="width:250px" placeholder="输入用户账号" id="admin-name" >
                <button class="btn btn-success" id="search-button"><i class="Hui-iconfont">&#xe665;</i> 搜用户</button>
            </div>
            <div class="cl pd-5 bg-1 bk-gray mt-20">
                <span class="l">
                    <!-- <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> -->
                    <a href="javascript:;" onclick="admin_add('添加用户','/permission/admin-add','800','500')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加用户</a>
                </span>
            </div>
            <div class="mt-20">
                <table class="table table-border table-bordered table-bg table-sort">
                    <thead>
                        <tr class="text-c">
                            <th width="25"><input type="checkbox" name="" value=""></th>
                            <th width="30">ID</th>
                            <th>账号</th>
                            <th>昵称</th>
                            <th width="40">性别</th>
                            <th width="140">角色</th>
                            <th width="140">创建时间</th>
                            <th width="140">更新时间</th>
                            <th width="40">状态</th>
                            <th width="100">操作</th>
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
            "searching": false,
            "ordering": false,
            "serverSide": true,
            "lengthMenu": [ 20, 50, 100, 200 ],
            "ajax": {
                "url": "/permission/administrators",
                "type": "post",
                "data": function(data){
                    data.columns[2]['search']['value'] = $("#admin-name").val();
                }
            },
            "createdRow": function( row, data, dataIndex ) {
                $(row).attr('class','text-c');
            },
            "columns": [
                {"data": null, "render": function( data, type, row, meta ){
                    return '<input type="checkbox" value="'+row.user_id+'" name="ids">';
                },"searchable": false},
                {"data": "user_id","searchable": false},
                {"data": "user_name","searchable": true},
                {"data": "nickname","searchable": false},
                {"data": "gender","searchable": false},
                {"data": "role_name","searchable": false},
                {"data": "created_at","searchable": false},
                {"data": "updated_at","searchable": false},
                {"data": "user_status", "render": function( data, type, row, meta ){
                    switch (data) {
                        case 0:
                            return "<span class='label radius'>已冻结</span>";
                        case 1:
                            return "<span class='label label-success radius'>正常</span>";
                    }
                }, "className": "td-status","searchable": false},
                {"data": null, "render": function( data, type, row, meta ){
                        var status_button = row.user_status ? '<a style="text-decoration:none" onClick="admin_frozen(this,'+row.user_id+')" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe631;</i></a>' : '<a onClick="admin_thaw(this,'+row.user_id+')" href="javascript:;" title="启用" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>';
                        return status_button+'<a title="编辑" href="javascript:;" onclick=admin_edit("编辑管理员","/permission/admin-edit",'+row.user_id+',"800","500","'+row.nickname+'",'+row.role_id+') class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>'+
                        '<a title="删除" href="javascript:;" onclick="admin_del(this,'+row.user_id+')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>';
                }, "className": "td-manage","searchable": false}
            ]
        } );
        /*表格检索*/
        $("#search-button").click(function(){
            table.api().ajax.reload();
        });
        /*管理员-增加*/
        function admin_add(title,url,w,h){
            layer_show(title,url,w,h);
        }
        /*管理员-编辑*/
        function admin_edit(title,url,id,w,h,nickname,role_id){
            url = url+'?id='+id+'&nickname='+nickname+'&role_id='+role_id;
            layer_show(title,url,w,h);
        }
        /*管理员-冻结*/
        function admin_frozen(obj,id){
            layer.confirm('确认要冻结吗？',function(index){
                $.ajax({
                    type: 'POST',
                    url: '/permission/admin-frozen-thaw',
                    dataType: 'json',
                    data: {'id': id,'status': 0},
                    async: false,
                    success: function(data){
                        if(data.code == 10000){
                            $(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_thaw(this,'+id+')" href="javascript:;" title="启用" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>');
                            $(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">已冻结</span>');
                            $(obj).remove();
                            layer.msg('已冻结!',{icon: 6,time:1000});
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
        /*管理员-启用*/
        function admin_thaw(obj,id){
            layer.confirm('确认要启用吗？',function(index){
                $.ajax({
                    type: 'POST',
                    url: '/permission/admin-frozen-thaw',
                    dataType: 'json',
                    data: {'id': id,'status': 1},
                    async: false,
                    success: function(data){
                        if(data.code == 10000){
                            $(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_frozen(this,'+id+')" href="javascript:;" title="冻结" style="text-decoration:none"><i class="Hui-iconfont">&#xe631;</i></a>');
                            $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">正常</span>');
                            $(obj).remove();
                            layer.msg('已启用!', {icon: 6,time:1000});
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
        /*管理员-删除*/
        function admin_del(obj,id){
            layer.confirm('确认要删除吗？',function(index){
                $.ajax({
                    type: 'GET',
                    url: '/permission/admin-delete',
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