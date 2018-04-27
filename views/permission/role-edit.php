<!DOCTYPE HTML>
<html>
    <head>
    <meta charset="utf-8">
        <meta name="renderer" content="webkit|ie-comp|ie-stand">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <!--[if lt IE 9]>
        <script type="text/javascript" src="lib/html5shiv.js"></script>
        <script type="text/javascript" src="lib/respond.min.js"></script>
        <![endif]-->
        <link rel="stylesheet" type="text/css" href="../css/H-ui.min.css" />
        <link rel="stylesheet" type="text/css" href="../css/H-ui.admin.css" />
        <link rel="stylesheet" type="text/css" href="../lib/Hui-iconfont/1.0.8/iconfont.css" />
        <link rel="stylesheet" type="text/css" href="../skin/default/skin.css" id="skin" />
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../lib/zTree/v3/css/zTreeStyle/zTreeStyle.css" />
        <!--[if IE 6]>
        <script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js" ></script>
        <script>DD_belatedPNG.fix('*');</script>
        <![endif]-->
    </head>
    <body>
        <article class="page-container">
            <form class="form form-horizontal" id="form-role-edit">
                <input type="hidden" name="role_id" value="<?=$id?>">
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>角色名称：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" id="role_name" name="role_name" value="<?=$role_name?>">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>分配菜单：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <ul id="meun_tree" class="ztree"></ul>
                    </div>
                </div>
                <div class="row cl">
                    <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                        <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提&nbsp;&nbsp;交&nbsp;&nbsp;">
                    </div>
                </div>
            </form>
        </article>
        <!--_footer 作为公共模版分离出去-->
        <script type="text/javascript" src="../lib/jquery/1.9.1/jquery.min.js"></script>
        <script type="text/javascript" src="../lib/layer/2.4/layer.js"></script>
        <script type="text/javascript" src="../js/H-ui.min.js"></script>
        <script type="text/javascript" src="../js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

        <!--请在下方写此页面业务相关的脚本-->
        <script type="text/javascript" src="../lib/zTree/v3/js/jquery.ztree.all-3.5.min.js"></script>
        <script type="text/javascript" src="../lib/jquery.validation/1.14.0/jquery.validate.js"></script>
        <script type="text/javascript" src="../lib/jquery.validation/1.14.0/validate-methods.js"></script>
        <script type="text/javascript" src="../lib/jquery.validation/1.14.0/messages_zh.js"></script>
        <script type="text/javascript">
        var setting = {
            data: {
                simpleData: {
                    enable:true,
                    idKey: "id",
                    pIdKey: "pId",
                    rootPId: ""
                }
            },
            callback: {
                beforeClick: function(treeId, treeNode) {
                    var zTree = $.fn.zTree.getZTreeObj(treeId);
                    if (treeNode.isParent) {
                        zTree.expandNode(treeNode);
                        return false;
                    } else {
                        return true;
                    }
                }
            },
            check: {
                enable: true,
		        chkStyle: "checkbox",
            }
        };

        var zNodes = [
            <?php foreach ($meun_list as $value) {
                if($value['type'] == 0){
                    echo "{ id:{$value['permission_id']}, pId:0, name:'{$value['name']}', checked:{$value['is_checked']}, open:true},";
                }else{
                    echo "{ id:{$value['permission_id']}, pId:{$value['parent_id']}, name:'{$value['name']}', checked:{$value['is_checked']}},";
                }
            } ?>
        ];
        function checkedValue() {
            var treeObj = $.fn.zTree.getZTreeObj("meun_tree");
            var nodes = treeObj.getCheckedNodes(true);
            var value = "";
            for (var i = 0; i < nodes.length; i++) {
                value += nodes[i].id + "/";
            }
            return value.substring(0, value.length - 1);
        }
        $(document).ready(function(){
            var ztreeObj = $.fn.zTree.init($("#meun_tree"), setting, zNodes);
            $("#form-role-edit").validate({
                rules:{
                    role_name:{
                        required:true,
                        minlength:2,
                        maxlength:6
                    }
                },
                onkeyup:false,
                success:"valid",
                submitHandler:function(form){
                    $(form).ajaxSubmit({
                        type: "post",
                        url: "/permission/role-edit",
                        dataType: "json",
                        data: {"chose_list": checkedValue()},
                        success: function(data){
                            if(data.code == 10000){
                                layer.msg('修改成功！',{icon:1,time:1000},function(){
                                    parent.location.reload();
                                    var index = parent.layer.index;
                                    parent.layer.close(index);
                                });
                            }else{
                                layer.msg(data.message,{icon:5});
                            }
                        },
                        error: function(data){
                            console.log(data.message);
                        }
                    });
                }
            });
        });
        </script>
    </body>
</html>