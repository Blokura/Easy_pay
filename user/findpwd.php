<?php

include("../includes/common.php");

if($conf['is_reg']==0)sysmsg('未开放商户申请');
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title>找回商户信息 | <?php echo $conf['web_name']?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<link rel="stylesheet" href="https://template.down.swap.wang/ui/angulr_2.0.1/bower_components/bootstrap/dist/css/bootstrap.css" type="text/css" />
<link rel="stylesheet" href="https://template.down.swap.wang/ui/angulr_2.0.1/bower_components/animate.css/animate.css" type="text/css" />
<link rel="stylesheet" href="https://template.down.swap.wang/ui/angulr_2.0.1/bower_components/font-awesome/css/font-awesome.min.css" type="text/css" />
<link rel="stylesheet" href="https://template.down.swap.wang/ui/angulr_2.0.1/bower_components/simple-line-icons/css/simple-line-icons.css" type="text/css" />
<link rel="stylesheet" href="https://template.down.swap.wang/ui/angulr_2.0.1/html/css/font.css" type="text/css" />
<link rel="stylesheet" href="https://template.down.swap.wang/ui/angulr_2.0.1/html/css/app.css" type="text/css" />
<style>input:-webkit-autofill{-webkit-box-shadow:0 0 0px 1000px white inset;-webkit-text-fill-color:#333;}img.logo{width:14px;height:14px;margin:0 5px 0 3px;}</style>
</head>
<body>
<div class="app app-header-fixed  ">
<div class="container w-xxl w-auto-xs" ng-controller="SigninFormController" ng-init="app.settings.container = false;">
<span class="navbar-brand block m-t" id="sitename"><?php echo $conf['web_name']?></span>
<div class="m-b-lg">
<div class="wrapper text-center">
<strong>输入您的邮箱来找回商户</strong>
</div>
<form name="form" class="form-validation">
<div class="list-group list-group-sm swaplogin">
<div class="list-group-item">
<input type="text" name="email" placeholder="邮箱" class="form-control no-border" required>
</div>
</div>
<button type="button" id="submit" class="btn btn-lg btn-primary btn-block" ng-click="login()" ng-disabled='form.$invalid'>发送</button>
<a href="login.php" ui-sref="access.signup" class="btn btn-lg btn-default btn-block">返回登录</a>
</form>
</div>
<div class="text-center">
<p>
<small class="text-muted"><?php echo $conf['web_name']?><br>&copy; 2016~2017</small>
</p>
</div>
</div>
</div>
<script src="https://template.down.swap.wang/ui/angulr_2.0.1/bower_components/jquery/dist/jquery.min.js"></script>
<script src="https://template.down.swap.wang/ui/angulr_2.0.1/bower_components/bootstrap/dist/js/bootstrap.js"></script>
<script src="../assets/layer/layer.js"></script>
<script>
$(document).ready(function(){
	$("#submit").click(function(){
		if ($(this).attr("data-lock") === "true") return;
		var email=$("input[name='email']").val();
		if(email==''){layer.alert('邮箱不能为空！');return false;}
		var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
		if(!reg.test(email)){layer.alert('邮箱格式不正确！');return false;}
		var ii = layer.load(2, {shade:[0.1,'#fff']});
		$.ajax({
			type : "POST",
			url : "ajax.php?act=find",
			data : {email:email},
			dataType : 'json',
			success : function(data) {
				layer.close(ii);
				if(data.code == 0){
					layer.msg('发送成功，请注意查收！');
				}else{
					layer.alert(data.msg);
				}
			} 
		});
	});
});
</script>
</body>
</html>