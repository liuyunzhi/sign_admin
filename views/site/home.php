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
		<div class="page-container">
			<p class="f-20 text-success text-c">欢迎使用 · 成都理工大学 · 考勤管理后台管理系统</p>
			<p>登录次数：<?=$login_count?> </p>
			<p>上次登录IP：<?=$last_login_log['login_ip']?>  上次登录时间：<?=$last_login_log['login_time']?> <?php if(isset($last_login_log['is_first_login'])&&$last_login_log['is_first_login']){echo '首次登录，感谢您的使用！';}?></p>
			<div id="container" style="min-width:700px;height:400px"></div>
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
					本后台系统由<a href="http://www.cdut.com/" target="_blank" title="成都理工大学">成都理工大学</a> 刘云志 提供技术支持</p>
			</div>
		</footer>
		<script type="text/javascript" src="../lib/jquery/1.9.1/jquery.min.js"></script> 
		<script type="text/javascript" src="../js/H-ui.min.js"></script>
		<script type="text/javascript" src="../lib/hcharts/Highcharts/5.0.6/js/highcharts.js"></script>
		<script type="text/javascript" src="../lib/hcharts/Highcharts/5.0.6/js/modules/exporting.js"></script>
		<script type="text/javascript">
		$(function () {
			$('#container').highcharts({
				chart: {
					type: 'column'
				},
				title: {
					text: '各科出勤率'
				},
				subtitle: {
					text: '数据来源：本系统数据'
				},
				xAxis: {
					categories: <?=$subjects?>,
					title: {
						text: '科目'
					}
				},
				yAxis: {
					min: 0,
					max: 100,
					title: {
						text: '出勤率 (%)'
					}
				},
				tooltip: {
					headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
					pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
						'<td style="padding:0"><b>{point.y:.1f} %</b></td></tr>',
					footerFormat: '</table>',
					shared: true,
					useHTML: true
				},
				plotOptions: {
					column: {
						pointPadding: 0.2,
						borderWidth: 0
					}
				},
				series: <?=$series?>
			});
		});				
		</script>
	</body>
</html>