<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="renderer" content="webkit|ie-comp|ie-stand">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
		<meta http-equiv="Cache-Control" content="no-siteapp" />
		<meta name="description" content="成都理工大学考勤管理系统">
		<link rel="Bookmark" href="favicon.ico" >
		<link rel="Shortcut Icon" href="favicon.ico" />
		<!--[if lt IE 9]>
		<script type="text/javascript" src="lib/html5shiv.js"></script>
		<script type="text/javascript" src="lib/respond.min.js"></script>
		<![endif]-->
		<link rel="stylesheet" type="text/css" href="css/H-ui.min.css" />
		<link rel="stylesheet" type="text/css" href="css/H-ui.admin.css" />
		<link rel="stylesheet" type="text/css" href="lib/Hui-iconfont/1.0.8/iconfont.css" />
		<link rel="stylesheet" type="text/css" href="skin/default/skin.css" id="skin" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<!--[if IE 6]>
		<script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js" ></script>
		<script>DD_belatedPNG.fix('*');</script>
		<![endif]-->
		<title>后台管理系统 - 成都理工大学</title>
	</head>
	<body>
		<header class="navbar-wrapper">
			<div class="navbar navbar-fixed-top">
				<div class="container-fluid cl">
					<a class="logo navbar-logo f-l mr-10 hidden-xs" href="http://www.cdut.edu.cn" target="_blank" style="color:#fff">成都理工大学</a> <a class="logo navbar-logo-m f-l mr-10 visible-xs" href="http://www.cdut.edu.cn" target="_blank" style="color:#fff">成都理工大学</a>
					<span class="logo navbar-slogan f-l mr-10 hidden-xs"> · 考勤管理后台管理系统 v1.0</span>
					<a aria-hidden="false" class="nav-toggle Hui-iconfont visible-xs" href="javascript:;">&#xe667;</a>
					<nav class="nav navbar-nav">
						<ul class="cl">
							<!-- <li class="dropDown dropDown_hover"><a href="javascript:;" class="dropDown_A"><i class="Hui-iconfont">&#xe600;</i> 新增 <i class="Hui-iconfont">&#xe6d5;</i></a>
								<ul class="dropDown-menu menu radius box-shadow">
									<li><a href="javascript:;" onclick=""><i class="Hui-iconfont">&#xe616;</i> 资讯</a></li>
									<li><a href="javascript:;" onclick=""><i class="Hui-iconfont">&#xe613;</i> 图片</a></li>
									<li><a href="javascript:;" onclick=""><i class="Hui-iconfont">&#xe620;</i> 产品</a></li>
									<li><a href="javascript:;" onclick=""><i class="Hui-iconfont">&#xe60d;</i> 用户</a></li>
								</ul>
							</li> -->
						</ul>
					</nav>
					<nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
						<ul class="cl">
							<li><?=$admin_info['role_name']?></li>
							<li class="dropDown dropDown_hover">
								<a href="#" class="dropDown_A"><?=$admin_info['nickname']?><i class="Hui-iconfont">&#xe6d5;</i></a>
								<ul class="dropDown-menu menu radius box-shadow">
									<li><a href="javascript:;" onClick="myself_info()">个人信息</a></li>
									<li><a href="/login/logout">退出</a></li>
								</ul>
							</li>
							<li id="Hui-msg"> <a href="/site/home" title="消息"><span class="badge badge-danger">0</span><i class="Hui-iconfont" style="font-size:18px">&#xe68a;</i></a> </li>
							<li id="Hui-skin" class="dropDown right dropDown_hover"> <a href="javascript:;" class="dropDown_A" title="换肤"><i class="Hui-iconfont" style="font-size:18px">&#xe62a;</i></a>
								<ul class="dropDown-menu menu radius box-shadow">
									<li><a href="javascript:;" data-val="default" title="默认（蓝色）">默认（蓝色）</a></li>
									<li><a href="javascript:;" data-val="blue" title="黑色">黑色</a></li>
									<li><a href="javascript:;" data-val="green" title="绿色">绿色</a></li>
									<li><a href="javascript:;" data-val="red" title="红色">红色</a></li>
									<li><a href="javascript:;" data-val="yellow" title="黄色">黄色</a></li>
									<li><a href="javascript:;" data-val="orange" title="橙色">橙色</a></li>
								</ul>
							</li>
						</ul>
					</nav>
				</div>
			</div>
		</header>
		<aside class="Hui-aside">
			<div class="menu_dropdown bk_2">
				<?php
					$is_first = true;
					foreach($admin_info['permission_list'] as $value){
						if($value['status'] == 1){
							if($value['type'] == 0 && $is_first){
								$is_first = false;?>
								<dl>
									<dt><i class="Hui-iconfont"> <?=$value['icon']?> </i><?=$value['name']?><i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
									<dd>
										<ul>
							<?php
							}elseif($value['type'] == 0){?>
										</ul>
									</dd>
								</dl>
								<dl>
									<dt><i class="Hui-iconfont"> <?=$value['icon']?> </i><?=$value['name']?><i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
									<dd>
										<ul>
							<?php
							}else{?>
								<li><a data-href="<?=$value['controller'].'/'.$value['action']?>" data-title="<?=$value['name']?>"><?=$value['name']?></a></li>
							<?php
							}
						}
					}
				?>
						</ul>
					</dd>
				</dl>
			</div>
		</aside>
		<!-- <div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div> -->
		<section class="Hui-article-box">
			<div id="Hui-tabNav" class="Hui-tabNav hidden-xs">
				<div class="Hui-tabNav-wp">
					<ul id="min_title_list" class="acrossTab cl">
						<li class="active">
							<span title="概览" data-href="welcome.html">概览</span>
							<em></em>
						</li>
					</ul>
				</div>
				<div class="Hui-tabNav-more btn-group"><a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d4;</i></a><a id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d7;</i></a></div>
			</div>
			<div id="iframe_box" class="Hui-article">
				<div class="show_iframe">
					<div style="display:none" class="loading"></div>
					<iframe scrolling="yes" frameborder="0" src="/site/home"></iframe>
				</div>
			</div>
		</section>

		<div class="contextMenu" id="Huiadminmenu">
			<ul>
				<li id="closethis">关闭当前 </li>
				<li id="closeall">关闭全部 </li>
		</ul>
		</div>
		<!--_footer 作为公共模版分离出去-->
		<script type="text/javascript" src="lib/jquery/1.9.1/jquery.min.js"></script>
		<script type="text/javascript" src="lib/layer/2.4/layer.js"></script>
		<script type="text/javascript" src="js/H-ui.min.js"></script>
		<script type="text/javascript" src="js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

		<!--请在下方写此页面业务相关的脚本-->
		<script type="text/javascript" src="lib/jquery.contextmenu/jquery.contextmenu.r2.js"></script>
		<script type="text/javascript">
		/*个人信息*/
		function myself_info(){
			layer.open({
				type: 1,
				area: ['300px','200px'],
				fix: false, //不固定
				maxmin: true,
				shade:0.4,
				title: '查看个人信息',
				content: '<p class="c-primary text-c mt-20">姓名：<?=$admin_info['nickname']?></p><p class="c-primary text-c mt-20">角色：<?=$admin_info['role_name']?></p>'
			});
		}
		</script>
	</body>
</html>