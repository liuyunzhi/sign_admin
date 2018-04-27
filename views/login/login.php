<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="0"> 
	<title>登录 - 成都理工大学考勤管理系统</title>
	<link href="../css/login-default.css" rel="stylesheet" type="text/css" />
	<!--必要样式-->
	<link href="../css/login-styles.css" rel="stylesheet" type="text/css" />
	<link href="../css/login-basics.css" rel="stylesheet" type="text/css" />
	<link href="../css/login-loaders.css" rel="stylesheet" type="text/css" />

	<link href="../lib/layui/css/layui.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div class='login'>
		<div class='login_title'>
		<img src="../../images/tittle.png" />
		</div>
	  <div class='login_fields'>
			<div class='login_fields__user'>
				<div class='icon'>
	        <img alt="" src='../../images/user_icon_copy.png'>
	      </div>
	      <input name="login" placeholder='用户名' maxlength="16" type='text' autocomplete="off"/>
				<div class='validation'>
					<img alt="" src='../../images/tick.png'>
				</div>
		</div>
		<span class="hint"></span>
		<div class='login_fields__password'>
			<div class='icon'>
				<img alt="" src='../../images/key.png'>
			</div>
			<input name="pwd" placeholder='密码' maxlength="16" type='text' autocomplete="off">
			<div class='validation'>
				<img alt="" src='../../images/tick.png'>
			</div>
		</div>
		<span class="hint"></span>
		<div class='login_fields__submit'>
			<input type='button' value='登录'>
		</div>
	  </div>
	  	<div class='success'>
	  </div>
	  <div class='disclaimer'>
	    <p>Copyright &copy; <script>document.write(new Date().getFullYear());</script><a href="http://www.cdut.edu.cn" target="_blank"> 成都理工大学 </a>版权所有</p>
	  </div>
	</div>
	<div class='authent'>
		<div class="loader" style="height: 44px;width: 44px;margin-left: 28px;">
			<div class="loader-inner ball-clip-rotate-multiple">
				<div></div>
				<div></div>
				<div></div>
			</div>
		</div>
	  <p>认证中...</p>
	</div>
	<div class="OverWindows"></div>

	<script src="../lib/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
	<script src="../lib/jquery-ui.min.js" type="text/javascript"></script>
	<script src="../lib/jquery.mockjax.js" type="text/javascript"></script>
	<script src="../lib/Particleground.js" type="text/javascript"></script>
	<script src="../lib/layui/layui.js" type="text/javascript"></script>
	<script src="../js/stopExecutionOnTimeout.js?t=1" type="text/javascript"></script>
	<script src="../js/Treatment.js" type="text/javascript"></script>
	<script src="../js/login.js" type="text/javascript"></script>
</body>
</html>
