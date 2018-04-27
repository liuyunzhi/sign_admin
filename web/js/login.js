$(document).keypress(function (e) {
    // 回车键事件  
    if (e.which == 13) {
        $('input[type="button"]').click();
    }
});
//粒子背景特效
$('body').particleground({
    dotColor: '#E8DFE8',
    lineColor: '#133b88'
});
$('input[name="pwd"]').focus(function () {
    $(this).attr('type', 'password');
});
$('input[type="text"]').focus(function () {
    $(this).prev().animate({ 'opacity': '1' }, 200);
});
$('input[type="text"],input[type="password"]').blur(function () {
    $(this).prev().animate({ 'opacity': '.5' }, 200);
});
$('input[name="login"],input[name="pwd"]').focus(function () {
    $(this).parent().next('span.hint').html('由6~16位的数字、字母或下划线组成');
});
$('input[name="login"],input[name="pwd"]').blur(function () {
    $(this).parent().next('span.hint').html('');
});
$('input[name="login"],input[name="pwd"]').keyup(function () {
    var regular = /\W/g;
    var Len = $(this).val().length;
    if(regular.test($(this).val())){
        $(this).parent().next('span.hint').html('存在非法字符!');
        $('input[type="button"]').attr("disabled",true);
        $(this).next().animate({
            'opacity': '0',
            'right': '20'
        }, 200);
    }else{
        if(Len < 6){
            $(this).parent().next('span.hint').html('长度小于6位！');
            $('input[type="button"]').attr("disabled",true);
            $(this).next().animate({
                'opacity': '0',
                'right': '20'
            }, 200);
        }else{
            $('input[type="button"]').attr("disabled",false);
            $(this).parent().next('span.hint').html('');
            $(this).next().animate({
                'opacity': '1',
                'right': '30'
            }, 200);
        }
    }
});

var open = 0;
layui.use('layer', function () {
    // 非空验证
    $('input[type="button"]').click(function () {
        var login = $('input[name="login"]').val();
        var pwd = $('input[name="pwd"]').val();
        // var code = $('input[name="code"]').val();
        if (login == '') {
            ErroAlert('请输入您的账号');
        } else if (pwd == '') {
            ErroAlert('请输入密码');
        // } else if (code == '' || code.length != 4) {
        } else {
            // 认证中..
            // fullscreen();
            $('.login').addClass('test'); //倾斜特效
            setTimeout(function () {
                $('.login').addClass('testtwo'); //平移特效
            }, 300);
            setTimeout(function () {
                $('.authent').show().animate({ right: -320 }, {
                    easing: 'easeOutQuint',
                    duration: 600,
                    queue: false
                });
                $('.authent').animate({ opacity: 1 }, {
                    duration: 200,
                    queue: false
                }).addClass('visible');
            }, 500);

            //登陆
            var JsonData = { account: login, password: pwd };
            //此处做为ajax内部判断
            var url = "login";
            
            AjaxPost(url, JsonData,
                            function () {
                                //ajax加载中
                            },
                            function (data) {
                                //ajax返回 
                                //认证完成
                                setTimeout(function () {
                                    $('.authent').show().animate({ right: 90 }, {
                                        easing: 'easeOutQuint',
                                        duration: 600,
                                        queue: false
                                    });
                                    $('.authent').animate({ opacity: 0 }, {
                                        duration: 200,
                                        queue: false
                                    }).addClass('visible');
                                    $('.login').removeClass('testtwo'); //平移特效
                                }, 2000);
                                setTimeout(function () {
                                    $('.authent').hide();
                                    $('.login').removeClass('test');
                                    if (data.code == "200") {
                                        //登录成功
                                        $('.login div').fadeOut(100);
                                        $('.success').fadeIn(1000);
                                        $('.success').html(data.messege);
                                        //跳转操作
                                        window.location.href = '/';
                                    } else {
                                        AjaxErro(data);
                                    }
                                }, 2400);
                            })
        }
    })
});