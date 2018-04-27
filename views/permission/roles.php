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
        <title>角色列表</title>
    </head>
    <body>
        <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 权限管理 <span class="c-gray en">&gt;</span> 角色管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
        <div class="page-container">
            <div class="text-c">
                <input type="text" class="input-text" style="width:250px" placeholder="输入角色名称" id="role-name" >
                <button class="btn btn-success" id="search-button"><i class="Hui-iconfont">&#xe665;</i>搜角色</button>
            </div>
            <div class="cl pd-5 bg-1 bk-gray mt-20">
                <span class="l">
                    <!-- <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> -->
                    <a href="javascript:;" onclick="role_add('添加角色','/permission/role-add','800','200')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i>添加角色</a>
                </span>
            </div>
            <div class="mt-20">
                <table class="table table-border table-bordered table-bg table-sort">
                    <thead>
                        <tr class="text-c">
                            <th width="25"><input type="checkbox" name="" value=""></th>
                            <th width="30">ID</th>
                            <th>角色名称</th>
                            <th width="140">创建时间</th>
                            <th width="140">更新时间</th>
                            <th width="90">操作</th>
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
                "url": "/permission/roles",
                "type": "post",
                "data": function(data){
                    data.columns[2]['search']['value'] = $("#role-name").val();
                }
            },
            "createdRow": function( row, data, dataIndex ) {
                $(row).attr('class','text-c');
            },
            "columns": [
                {"data": null, "render": function( data, type, row, meta ){
                    return '<input type="checkbox" value="'+row.role_id+'" name="ids">';
                },"searchable": false},
                {"data": "role_id","searchable": false},
                {"data": "role_name","searchable": true},
                {"data": "created_at","searchable": false},
                {"data": "updated_at","searchable": false},
                {"data": null, "render": function( data, type, row, meta ){
                    return '<a onClick=role_show("查看角色详情","/permission/role-show",'+row.role_id+',"800","500") href="javascript:;" title="查看" style="text-decoration:none"><i class="Hui-iconfont">&#xe725;</i></a>'
                    +'<a title="编辑" href="javascript:;" onclick=role_edit("编辑角色","/permission/role-edit",'+row.role_id+',"800","500","'+row.role_name+'") class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>'
                    +'<a title="删除" href="javascript:;" onclick="role_del(this,'+row.role_id+')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>';
                },"searchable": false}
            ]
        } );
        /*表格检索*/
        $("#search-button").click(function(){
            table.api().ajax.reload();
        });
        /*角色-查看*/
        function role_show(title,url,id,w,h){
            url = url+'?id='+id;
            layer_show(title,url,w,h);
        }
        /*角色-增加*/
        function role_add(title,url,w,h){
            layer_show(title,url,w,h);
        }
        /*角色-删除*/
        function role_del(obj,id){
            layer.confirm('确认要删除吗？',function(index){
                $.ajax({
                    type: 'GET',
                    url: '/permission/role-delete',
                    dataType: 'json',
                    data: {'id': id},
                    success: function(data){
                        if(data.code == 10000){
                            $(obj).parents("tr").remove();
                            layer.msg('已删除!',{icon:1,time:1000});
                            table.api().ajax.reload();
                        }else{
                            layer.msg(data.message,{icon:5});
                        }
                    },
                    error:function(data) {
                        console.log(data.msg);
                    },
                });
            });
        }
        /*角色-编辑*/
        function role_edit(title,url,id,w,h,role_name){
            url = url+'?id='+id+'&name='+role_name;
            layer_show(title,url,w,h);
        }
        </script>
    </body>
</html>