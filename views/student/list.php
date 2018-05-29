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
        <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 学生管理 <span class="c-gray en">&gt;</span> 学生列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
        <div class="page-container">
            <div class="text-c">
                <input type="text" class="input-text" style="width:250px" placeholder="输入学号" id="student_id" >
                <input type="text" class="input-text" style="width:250px" placeholder="输入学生名" id="name" >
                <button class="btn btn-success" id="search-button"><i class="Hui-iconfont">&#xe665;</i> 搜学生</button>
            </div>
            <div class="cl pd-5 bg-1 bk-gray mt-20">
                <span class="l">
                    <!-- <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> -->
                    <a href="javascript:;" onclick="student_add('添加学生','/student/add','800','500')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加学生</a>
                </span>
            </div>
            <div class="mt-20">
                <table class="table table-border table-bordered table-bg table-sort">
                    <thead>
                        <tr class="text-c">
                            <th width="25"><input type="checkbox" name="" value=""></th>
                            <th width="30">ID</th>
                            <th width='100'>学号</th>
                            <th width='150'>身份证号</th>
                            <th>姓名</th>
                            <th width='30'>性别</th>
                            <th>学院</th>
                            <th>专业</th>
                            <th width='100'>电话</th>
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
        <script type="text/javascript" src="../lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="../lib/laypage/1.2/laypage.js"></script>
        <script type="text/javascript">
        var table = $('.table-sort').dataTable( {
            "searching": false,
            "ordering": false,
            "serverSide": true,
            "lengthMenu": [ 20, 50, 100, 200 ],
            "ajax": {
                "url": "/student/list",
                "type": "post",
                "data": function(data){
                    data.columns[2]['search']['value'] = $("#student_id").val();
                    data.columns[4]['search']['value'] = $("#name").val();
                }
            },
            "createdRow": function( row, data, dataIndex ) {
                $(row).attr('class','text-c');
            },
            "columns": [
                {"data": null, "render": function( data, type, row, meta ){
                    return '<input type="checkbox" value="'+row.id+'" name="ids">';
                },"searchable": false},
                {"data": "id","searchable": false},
                {"data": "student_id","searchable": true},
                {"data": "person_id","searchable": false},
                {"data": "name","searchable": true},
                {"data": "gender", "render": function( data, type, row, meta ){
                    switch (data) {
                        case 0:
                            return "男";
                        case 1:
                            return "女";
                    }
                },"searchable": false},
                {"data": "college","searchable": false},
                {"data": "faculty","searchable": false},
                {"data": "phone","searchable": false},
                {"data": "created_date","searchable": false},
                {"data": "update_date","searchable": false},
                {"data": null, "render": function( data, type, row, meta ){
                        return '<a onClick=sign_show("查看考勤记录详情","/sign/records-student",'+row.id+',"1200","600") href="javascript:;" title="查看考勤记录" style="text-decoration:none"><i class="Hui-iconfont">&#xe725;</i></a>'
                            +'<a title="编辑" href="javascript:;" onclick=student_edit("编辑学生","/student/edit",'+row.id+',"800","500") class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>'
                            + '<a title="删除" href="javascript:;" onclick="student_del(this,'+row.id+')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>';
                }, "searchable": false}
            ]
        } );
        /*表格检索*/
        $("#search-button").click(function(){
            table.api().ajax.reload();
        });
        /*学生-增加*/
        function student_add(title,url,w,h){
            layer_show(title,url,w,h);
        }
        /*查看考勤记录*/
        function sign_show(title,url,id,w,h){
            url = url+'?id='+id;
            layer_show(title,url,w,h);
        }
        /*学生-编辑*/
        function student_edit(title,url,id,w,h){
            url = url+'?id='+id;
            layer_show(title,url,w,h);
        }
        /*学生-删除*/
        function student_del(obj,id){
            layer.confirm('确认要删除吗？',function(index){
                $.ajax({
                    type: 'GET',
                    url: '/student/delete',
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