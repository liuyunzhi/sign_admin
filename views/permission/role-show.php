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
        <div class="page-container">
            <div class="mt-20">
                <table class="table table-border table-bordered table-bg table-sort">
                    <thead>
                        <tr class="text-c">
                            <th width="50">用户ID</th>
                            <th>账号</th>
                            <th>昵称</th>
                            <th width="40">性别</th>
                            <th width="140">创建时间</th>
                            <th width="140">更新时间</th>
                            <th width="40">状态</th>
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
            $('.table-sort').dataTable( {
                "paging": false,
                "searching": false,
                "ordering": false,
                "serverSide": true,
                "ajax": {
                    "url": "/permission/role-show",
                    "type": "post",
                    "data": function(data){
                        data.search['value'] = <?=$role_id?>;
                    }
                },
                "createdRow": function( row, data, dataIndex ) {
                    $(row).attr('class','text-c');
                },
                "columns": [
                    {"data": "user_id"},
                    {"data": "user_name"},
                    {"data": "nickname"},
                    {"data": "gender"},
                    {"data": "created_at"},
                    {"data": "updated_at"},
                    {"data": "user_status", "render": function( data, type, row, meta ){
                        switch (data) {
                            case 0:
                                return "<span class='label radius'>已冻结</span>";
                            case 1:
                                return "<span class='label label-success radius'>正常</span>";
                        }
                    }},
                ]
            } );
        </script>
    </body>
</html>