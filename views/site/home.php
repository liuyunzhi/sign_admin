﻿<!DOCTYPE HTML>
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
		<div class="page-container">
			<p class="f-20 text-success text-c">欢迎使用 · 成都理工大学 · 考勤管理后台管理系统</p>
			<p>登录次数：<?=$login_count?> </p>
			<p>上次登录IP：<?=$last_login_log['login_ip']?>  上次登录时间：<?=$last_login_log['login_time']?> <?php if(isset($last_login_log['is_first_login'])&&$last_login_log['is_first_login']){echo '首次登录，感谢您的使用！';}?></p>
			<table class="table table-border table-bordered table-bg">
				<thead>
					<tr>
						<th colspan="7" scope="col">信息统计</th>
					</tr>
					<tr class="text-c">
						<th>统计</th>
						<th>资讯库</th>
						<th>图片库</th>
						<th>产品库</th>
						<th>用户</th>
						<th>管理员</th>
					</tr>
				</thead>
				<tbody>
					<tr class="text-c">
						<td>总数</td>
						<td>92</td>
						<td>9</td>
						<td>0</td>
						<td>8</td>
						<td>20</td>
					</tr>
					<tr class="text-c">
						<td>今日</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr class="text-c">
						<td>昨日</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr class="text-c">
						<td>本周</td>
						<td>2</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr class="text-c">
						<td>本月</td>
						<td>2</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
				</tbody>
			</table>
			<table class="table table-border table-bordered table-bg mt-20">
				<thead>
					<tr>
						<th colspan="2" scope="col">客户端信息</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th width="30%">客户端计算机名</th>
						<td><span id="lbServerName"><?=gethostbyaddr($_SERVER['REMOTE_ADDR'])?></span></td>
					</tr>
					<tr>
						<td>客户端IP地址</td>
						<td><?=$_SERVER['REMOTE_ADDR']?></td>
					</tr>
					<tr>
						<td>客户端端口</td>
						<td><?=$_SERVER['REMOTE_PORT']?></td>
					</tr>
					<tr>
						<td>客户端类型</td>
						<td><?=$_SERVER['HTTP_USER_AGENT']?></td>
					</tr>
				</tbody>
			</table>
			<table class="table table-border table-bordered table-bg mt-20">
				<thead>
					<tr>
						<th colspan="2" scope="col">服务器信息</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th width="30%">服务器计算机名</th>
						<td><span id="lbServerName"><?=$_SERVER['SERVER_NAME']?></span></td>
					</tr>
					<tr>
						<td>服务器IP地址</td>
						<td><?=$_SERVER['SERVER_ADDR']?></td>
					</tr>
					<tr>
						<td>服务器域名</td>
						<td><?=$_SERVER['HTTP_HOST']?></td>
					</tr>
					<tr>
						<td>服务器端口</td>
						<td><?=$_SERVER['SERVER_PORT']?></td>
					</tr>
					<tr>
						<td>服务器操作系统</td>
						<td>Linux</td>
					</tr>
					<tr>
						<td>服务器WEB容器</td>
						<td><?=$_SERVER['SERVER_SOFTWARE']?></td>
					</tr>
					<tr>
						<td>服务器的语言种类 </td>
						<td>Chinese (People's Republic of China)</td>
					</tr>
					<tr>
						<td>服务器当前时间 </td>
						<td><?=date("Y-m-d H:i:s")?></td>
					</tr>
				</tbody>
			</table>
		</div>
		<footer class="footer mt-20">
			<div class="container">
				<p>Copyright &copy;2018-<script>document.write(new Date().getFullYear());</script> cmc.admin v1.0 All Rights Reserved.<br>
					本后台系统由<a href="http://www.chinamcloud.com/" target="_blank" title="成都华栖云科技有限公司">成都华栖云科技有限公司</a>提供技术支持</p>
			</div>
		</footer>
		<script type="text/javascript" src="../lib/jquery/1.9.1/jquery.min.js"></script> 
		<script type="text/javascript" src="../js/H-ui.min.js"></script> 
	</body>
</html>