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
            <form class="form form-horizontal" id="form-record-edit">
                <input type="hidden" name="id" value="<?=$id?>">
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>考勤状态：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <span class="select-box" style="width:150px;">
                            <select class="select" name="result" size="1" id="result">
                                <option value="0" <?php echo $result == 0 ? "selected" : "";?>>到勤</option>
                                <option value="1" <?php echo $result == 1 ? "selected" : "";?>>迟到</option>
                                <option value="2" <?php echo $result == 2 ? "selected" : "";?>>缺勤</option>
                                <option value="3" <?php echo $result == 3 ? "selected" : "";?>>早退</option>
                                <option value="4" <?php echo $result == 4 ? "selected" : "";?>>正常</option>
                                <option value="5" <?php echo $result == 5 ? "selected" : "";?>>异常</option>
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
        $(document).ready(function(){
            $("#form-record-edit").validate({
                rules:{
                    result:{
                        required:true,
                    }
                },
                onkeyup:false,
                success:"valid",
                submitHandler:function(form){
                    $(form).ajaxSubmit({
                        type: "post",
                        url: "/sign/edit",
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
        </script>
    </body>
</html>