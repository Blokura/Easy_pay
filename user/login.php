<?php
/**
 * 登录
**/
include("../includes/common.php");
if(isset($_POST['user']) && isset($_POST['pass'])){
	$user=daddslashes($_POST['user']);
	$pass=daddslashes($_POST['pass']);
	$userrow=$DB->query("SELECT * FROM pay_user WHERE id='{$user}' limit 1")->fetch();
	if($user==$userrow['id'] && $pass==$userrow['key']) {
		if($user_id=$_SESSION['Oauth_alipay_uid']){
			$DB->exec("update `pay_user` set `alipay_uid` ='$user_id' where `id`='$user'");
			unset($_SESSION['Oauth_alipay_uid']);
		}
		if($qq_openid=$_SESSION['Oauth_qq_uid']){
			$DB->exec("update `pay_user` set `qq_uid` ='$qq_openid' where `id`='$user'");
			unset($_SESSION['Oauth_qq_uid']);
		}
		//$city=get_ip_city($clientip);
		$DB->query("insert into `panel_log` (`uid`,`type`,`date`,`city`,`data`) values ('".$user."','登录用户中心','".$date."','".$city."','".$clientip."')");
		$session=md5($user.$pass.$password_hash);
		$expiretime=time()+604800;
		$token=authcode("{$user}\t{$session}\t{$expiretime}", 'ENCODE', SYS_KEY);
		setcookie("user_token", $token, time() + 604800);
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>alert('登录用户中心成功！');window.location.href='./';</script>");
	}else {
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>alert('用户名或密码不正确！');history.go(-1);</script>");
	}
}elseif(isset($_GET['logout'])){
	setcookie("user_token", "", time() - 604800);
	@header('Content-Type: text/html; charset=UTF-8');
	exit("<script language='javascript'>alert('您已成功注销本次登录！');window.location.href='./login.php';</script>");
}elseif($islogin2==1){
	exit("<script language='javascript'>alert('您已登录！');window.location.href='./';</script>");
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title>登录 | <?php echo $conf['web_name']?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<link rel="stylesheet" href="https://template.down.swap.wang/ui/angulr_2.0.1/bower_components/bootstrap/dist/css/bootstrap.css" type="text/css" />
<link rel="stylesheet" href="https://template.down.swap.wang/ui/angulr_2.0.1/bower_components/animate.css/animate.css" type="text/css" />
<link rel="stylesheet" href="https://template.down.swap.wang/ui/angulr_2.0.1/bower_components/font-awesome/css/font-awesome.min.css" type="text/css" />
<link rel="stylesheet" href="https://template.down.swap.wang/ui/angulr_2.0.1/bower_components/simple-line-icons/css/simple-line-icons.css" type="text/css" />
<link rel="stylesheet" href="https://template.down.swap.wang/ui/angulr_2.0.1/html/css/font.css" type="text/css" />
<link rel="stylesheet" href="https://template.down.swap.wang/ui/angulr_2.0.1/html/css/app.css" type="text/css" />
<style>input:-webkit-autofill{-webkit-box-shadow:0 0 0px 1000px white inset;-webkit-text-fill-color:#333;}</style>
</head>
<body>
<div class="app app-header-fixed  ">
<div class="container w-xxl w-auto-xs" ng-controller="SigninFormController" ng-init="app.settings.container = false;">
<span class="navbar-brand block m-t"><?php echo $conf['web_name']?></span>
<div class="m-b-lg">
<div class="wrapper text-center">
<strong>请输入您的商户信息</strong>
</div>
<form name="form" class="form-validation" method="post" action="login.php">
<div class="text-danger wrapper text-center" ng-show="authError">
</div>
<div class="list-group list-group-sm swaplogin">
<div class="list-group-item">
<input type="text" name="user" placeholder="商户ID" value="<?php echo @$_GET['user']?>" class="form-control no-border" required>
</div>
<div class="list-group-item">
<input type="password" name="pass" placeholder="商户密钥" value="<?php echo @$_GET['pass']?>" class="form-control no-border" required>
</div>
</div>
<button type="submit" class="btn btn-lg btn-primary btn-block" ng-click="login()" ng-disabled='form.$invalid'>立即登录</button>
<a href="oauth.php" ui-sref="access.signup" class="btn btn-lg btn-default btn-block <?php echo isset($_GET['connect'])||$conf['quicklogin']!=1?'hide':null;?>"><img src="../assets/icon/alipay.ico" width="28px">支付宝快捷登录</a>
<a href="connect.php" ui-sref="access.signup" class="btn btn-lg btn-default btn-block <?php echo isset($_GET['connect'])||$conf['quicklogin']!=2?'hide':null;?>"><img src="../assets/icon/qqpay.ico" width="28px">ＱＱ快捷登录</a>
<div class="line line-dashed"></div>
<a href="reg.php" ui-sref="access.signup" class="btn btn-lg btn-default btn-block <?php echo $conf['is_reg']==0?'hide':null;?>">自助申请商户</a>
<div class="text-center m-t m-b"><a ui-sref="access.forgotpwd" href="findpwd.php">找回商户信息</a></div>
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
</body>
</html>