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
        <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 考勤管理 <span class="c-gray en">&gt;</span> 考勤记录 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
        <div class="page-container">
            <div class="text-c">
                考勤状态：
                <span class="select-box inline">
                    <select class="select" id="result" name="result">
                        <option value="">全部</option>
                        <option value="0">到勤</option>
                        <option value="1">迟到</option>
                        <option value="2">缺勤</option>
                        <option value="3">早退</option>
                        <option value="4">正常</option>
                        <option value="5">异常</option>
                    </select>
                </span>
                <button class="btn btn-success" id="search-button"><i class="Hui-iconfont">&#xe665;</i> 搜记录</button>
            </div>
            <!-- <div class="cl pd-5 bg-1 bk-gray mt-20">
                <span class="l">
                    <a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
                </span>
            </div> -->
            <div class="mt-20">
                <table class="table table-border table-bordered table-bg table-sort">
                    <thead>
                        <tr class="text-c">
                            <th width="25"><input type="checkbox" name="" value=""></th>
                            <th width="30">ID</th>
                            <th width="70">学生</th>
                            <th>课程</th>
                            <th width="90">经度</th>
                            <th width="90">纬度</th>
                            <th width="140">时间</th>
                            <th width="40">状态</th>
                            <th width="140">创建时间</th>
                            <th width="140">更新时间</th>
                            <th width="30">操作</th>
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
                "url": "/sign/records",
                "type": "post",
                "data": function(data){
                    data.columns[7]['search']['value'] = $("#result").val();
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
                {"data": "student","searchable": false},
                {"data": "course","searchable": false},
                {"data": "longitude","searchable": false},
                {"data": "latitude","searchable": false},
                {"data": "time","searchable": false},
                {"data": "result", "render": function( data, type, row, meta ){
                    switch (data) {
                        case 0:
                            return "<span class='label label-primary radius'>到勤</span>";
                        case 1:
                            return "<span class='label label-warning radius'>迟到</span>";
                        case 2:
                            return "<span class='label label-default radius'>缺勤</span>";
                        case 3:
                            return "<span class='label label-secondary radius'>早退</span>";
                        case 4:
                            return "<span class='label label-success radius'>正常</span>";
                        case 5:
                            return "<span class='label label-danger radius'>异常</span>";
                    }
                },"searchable": true},
                {"data": "created_date","searchable": false},
                {"data": "update_date","searchable": false},
                {"data": null, "render": function( data, type, row, meta ){
                        return '<a title="编辑" href="javascript:;" onclick=record_edit("编辑考勤状态","/sign/edit",'+row.id+',"600","300",'+row.result+') class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>';
                },"searchable": false}
            ]
        } );
        /*表格检索*/
        $("#search-button").click(function(){
            table.api().ajax.reload();
        });
        /*考勤-编辑*/
        function record_edit(title,url,id,w,h,result){
            url = url+'?id='+id+'&result='+result;
            layer_show(title,url,w,h);
        }
        </script>
    </body>
</html>