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
            <form class="form form-horizontal" id="form-admin-add">
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>账号：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" id="admin_name" name="admin_name">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>昵称：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" id="nickname" name="nickname">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>初始密码：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="password" class="input-text" autocomplete="off" placeholder="密码" id="password" name="password">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>确认密码：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="password" class="input-text" autocomplete="off" placeholder="确认新密码" name="comfirm_password" id="comfirm_password">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>性别：</label>
                    <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                        <div class="radio-box">
                            <input type="radio" id="male" name="gender" value="男" checked>
                            <label for="male">男</label>
                        </div>
                        <div class="radio-box">
                            <input type="radio" id="female" name="gender" value="女">
                            <label for="female">女</label>
                        </div>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>角色：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <span class="select-box" style="width:150px;">
                            <select class="select" name="role" size="1">
                                <?php foreach ($role_list as $value) {
                                    echo "<option value='{$value['role_id']}'>{$value['role_name']}</option>";
                                } ?>
                            </select>
                        </span>
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
        <script type="text/javascript" src="../lib/jquery.validation/1.14.0/jquery.validate.js"></script>
        <script type="text/javascript" src="../lib/jquery.validation/1.14.0/validate-methods.js"></script>
        <script type="text/javascript" src="../lib/jquery.validation/1.14.0/messages_zh.js"></script>
        <script type="text/javascript">
        $(function(){
            $('.skin-minimal input').iCheck({
                checkboxClass: 'icheckbox-blue',
                radioClass: 'iradio-blue',
                increaseArea: '20%'
            });
            $("#form-admin-add").validate({
                rules:{
                    admin_name:{
                        required:true,
                        minlength:6,
                        maxlength:16
                    },
                    nickname:{
                        required:true
                    },
                    password:{
                        required:true,
                        minlength:6,
                        maxlength:16
                    },
                    comfirm_password:{
                        required:true,
                        equalTo: "#password",
                        minlength:6,
                        maxlength:16
                    },
                    gender:{
                        required:true
                    },
                    role:{
                        required:true
                    },
                },
                onkeyup:false,
                success:"valid",
                submitHandler:function(form){
                    $(form).ajaxSubmit({
                        type: "post",
                        url: "/permission/admin-add",
                        dataType: "json",
                        success: function(data){
                            if(data.code == 10000){
                                layer.msg('添加成功！',{icon:1,time:1000},function(){
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
        <!--/请在上方写此页面业务相关的脚本-->
    </body>
</html>