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
        <!--[if IE 6]>
        <script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js" ></script>
        <script>DD_belatedPNG.fix('*');</script>
        <![endif]-->
    </head>
    <body>
        <article class="page-container">
            <form class="form form-horizontal" id="form-meun-add">
                <input type="hidden" name="permission_id" value="<?=$permission_data['permission_id']?>">
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>菜单名称：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" id="meun_name" name="meun_name" value="<?=$permission_data['name']?>">
                    </div>
                </div>
                <!-- <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>所属类型：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <span class="select-box" style="width:150px;">
                            <select class="select" name="parent_id" size="1">
                                <?php /*if($permission_data['type']){
                                    foreach ($parent_permission as $value) {
                                        if($permission_data['parent_id'] == $value['permission_id']){
                                            echo "<option value='{$value['permission_id']}' selected>{$value['name']}</option>";
                                        }else{
                                            echo "<option value='{$value['permission_id']}'>{$value['name']}</option>";
                                        }
                                    }
                                } else{
                                    echo "<option value='0'>父级菜单</option>";
                                }*/ ?>
                            </select>
                        </span>
                    </div>
                </div> -->
                <?php if($permission_data['type']){ ?>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">控制器：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" id="controller" name="controller" value="<?=$permission_data['controller']?>">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">动作：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" name="action" id="action" value="<?=$permission_data['action']?>">
                    </div>
                </div>
                <?php } else{ ?>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>缩略图：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <i class="Hui-iconfont" id="selected-icon"><?=$permission_data['icon']?></i>
                        <input type="button" class="btn btn-secondary radius" onclick="select_icon('选择图标','/common/icon','780','440')" id="btn-select-icon" value="选择图标">
                        <input type="hidden" name="icon" id="selected-icon-code" value="<?=substr($permission_data['icon'], 4, 3)?>">
                    </div>
                </div>
                <?php } ?>
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
        <script type="text/javascript" src="../lib/jquery.validation/1.14.0/jquery.validate.js"></script>
        <script type="text/javascript" src="../lib/jquery.validation/1.14.0/validate-methods.js"></script>
        <script type="text/javascript" src="../lib/jquery.validation/1.14.0/messages_zh.js"></script>
        <script type="text/javascript">
        $(function(){
            $("#form-meun-add").validate({
                rules:{
                    meun_name:{
                        required:true,
                        minlength:2,
                        maxlength:6
                    }/*,parent_id:{
                        required:true,
                    }*/
                },
                onkeyup:false,
                success:"valid",
                submitHandler:function(form){
                    $(form).ajaxSubmit({
                        type: "post",
                        url: "/permission/meun-edit",
                        dataType: "json",
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
        /*菜单-增加*/
        function select_icon(title,url,w,h){
            layer_show(title,url,w,h);
        }
        </script>
        <!--/请在上方写此页面业务相关的脚本-->
    </body>
</html>