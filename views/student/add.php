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
            <form class="form form-horizontal" id="form-student-add">
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>学号：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" id="student_id" name="student_id">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>身份证号：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" id="person_id" name="person_id">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>姓名：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" id="name" name="name">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>性别：</label>
                    <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                        <div class="radio-box">
                            <input type="radio" id="male" name="gender" value="0" checked>
                            <label for="male">男</label>
                        </div>
                        <div class="radio-box">
                            <input type="radio" id="female" name="gender" value="1">
                            <label for="female">女</label>
                        </div>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>学院：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" name="college" id="college">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>专业：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" name="faculty" id="faculty">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>电话：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" name="phone" id="phone">
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
        <script type="text/javascript" src="../lib/jquery.validation/1.14.0/additional-methods.js"></script> 
        <script type="text/javascript" src="../lib/jquery.validation/1.14.0/messages_zh.js"></script> 
        <script type="text/javascript">
        $('.skin-minimal input').iCheck({
                checkboxClass: 'icheckbox-blue',
                radioClass: 'iradio-blue',
                increaseArea: '20%'
        });
        $(function(){
            $("#form-student-add").validate({
                rules:{
                    student_id:{
                        required:true,
                    },
                    person_id:{
                        required:true,
                        isIdCardNo:true
                    },
                    name:{
                        required:true,
                    },
                    gender:{
                        required:true,
                    },
                    college:{
                        required:true,
                    },
                    faculty:{
                        required:true,
                    },
                    phone:{
                        required:true,
                        isMobile:true
                    }
                },
                onkeyup:false,
                success:"valid",
                submitHandler:function(form){
                    $(form).ajaxSubmit({
                        type: 'post',
                        url: "/student/add" ,
                        success: function(data){
                            data = JSON.parse(data);
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
        /*菜单-增加*/
        function select_point(title,url,w,h){
            layer_show(title,url,w,h);
        }
        </script>
        <!--/请在上方写此页面业务相关的脚本-->
    </body>
</html>