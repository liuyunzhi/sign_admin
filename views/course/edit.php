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
            <form class="form form-horizontal" id="form-course-add">
                <input type="hidden" name="id" value="<?=$course_data['id']?>">
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>课程名称：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" id="course_name" name="course_name" value="<?=$course_data['name']?>">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>所在教室：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" id="course_position" name="course_position" value="<?=$course_data['position']?>">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>上课时间：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" onfocus="WdatePicker({ dateFmt:'yyyy-MM-dd HH:mm:ss' })" id="time" name="time" class="input-text Wdate" value="<?=$course_data['time']?>">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>授课教师：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" id="teacher" name="teacher" value="<?=$course_data['teacher']?>">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>经度：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" placeholder="手动输入经度" name="longitude" id="longitude" value="<?=$course_data['longitude']?>">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>纬度：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" placeholder="手动输入纬度" name="latitude" id="latitude" value="<?=$course_data['latitude']?>">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3">地图选点：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="button" class="btn btn-secondary radius" onclick="select_point('选择地点','/common/map','780','440')" id="btn-select-point" value="选择地点">
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
        <script type="text/javascript" src="../lib/My97DatePicker/4.8/WdatePicker.js"></script>
        <script type="text/javascript" src="../lib/jquery.validation/1.14.0/jquery.validate.js"></script> 
        <script type="text/javascript" src="../lib/jquery.validation/1.14.0/validate-methods.js"></script> 
        <script type="text/javascript" src="../lib/jquery.validation/1.14.0/additional-methods.js"></script> 
        <script type="text/javascript" src="../lib/jquery.validation/1.14.0/messages_zh.js"></script> 
        <script type="text/javascript">
        $(function(){
            $("#form-course-add").validate({
                rules:{
                    course_name:{
                        required:true,
                    },
                    course_position:{
                        required:true,
                    },
                    time:{
                        required:true,
                    },
                    teacher:{
                        required:true,
                    },
                    longitude:{
                        required:true,
                    },
                    latitude:{
                        required:true,
                    }
                },
                onkeyup:false,
                success:"valid",
                submitHandler:function(form){
                    $(form).ajaxSubmit({
                        type: 'post',
                        url: "/course/edit" ,
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