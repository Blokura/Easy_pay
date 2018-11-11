<?php 
require_once('../includes/common.php');
$alipay_config['partner'] = $conf['reg_pid'];
$alipay_config['key'] = $DB->query("SELECT `key` FROM `pay_user` WHERE `id`='{$conf['reg_pid']}' limit 1")->fetchColumn();
require_once("./epay_notify.class.php");

@header('Content-Type: text/html; charset=UTF-8');

//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyReturn();
if($verify_result) {
	//商户订单号
	$out_trade_no = $_GET['out_trade_no'];

	//支付宝交易号
	$trade_no = $_GET['trade_no'];

	//交易状态
	$trade_status = $_GET['trade_status'];

    if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
		$srow=$DB->query("SELECT * FROM pay_regcode WHERE trade_no='{$trade_no}' limit 1")->fetch();
		$array = explode('|',$srow['data']);
		$type = addslashes($array[0]);
		$account = addslashes($array[1]);
		$username = addslashes($array[2]);
		$url = addslashes($array[3]);
		if($srow['type']==1){
			$phone = addslashes($srow['email']);
			$email = addslashes($array[4]);
		}else{
			$email = addslashes($srow['email']);
		}
		if($srow['status']==0){
			$DB->exec("update `pay_regcode` set `status` ='1' where `id`='{$srow['id']}'");
			$key = random(32);
			$sds=$DB->exec("INSERT INTO `pay_user` (`key`, `account`, `username`, `money`, `url`, `email`, `phone`, `settle_id`, `addtime`, `type`, `active`) VALUES ('{$key}', '{$account}', '{$username}', '0', '{$url}', '{$email}', '{$phone}', '{$type}', '{$date}', '0', '1')");
			$pid=$DB->lastInsertId();
			if($sds){
				$scriptpath=str_replace('\\','/',$_SERVER['SCRIPT_NAME']);
				$sitepath = substr($scriptpath, 0, strrpos($scriptpath, '/'));
				$siteurl = ($_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].$sitepath.'/';
				$sub = $conf['web_name'].' - 注册成功通知';
				$msg = '<h2>商户注册成功通知</h2>感谢您注册'.$conf['web_name'].'！<br/>您的商户ID：'.$pid.'<br/>您的商户秘钥：'.$key.'<br/>'.$conf['web_name'].'官网：<a href="http://'.$_SERVER['HTTP_HOST'].'/" target="_blank">'.$_SERVER['HTTP_HOST'].'</a><br/>【<a href="'.$siteurl.'" target="_blank">商户管理后台</a>】';
				$result = send_mail($email, $sub, $msg);
			}else{
				sysmsg('申请商户失败！'.$DB->errorCode());
			}
		}else{
			$row=$DB->query("SELECT * FROM pay_user WHERE account='$account' and email='$email' order by id desc limit 1")->fetch();
			if($row){
				$pid = $row['id'];
				$key = $row['key'];
			}else{
				sysmsg('申请商户失败！');
			}
		}
    }
}
else {
    sysmsg('签名校验失败！');
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title>申请商户成功 | <?php echo $conf['web_name']?></title>
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
<span class="navbar-brand block m-t">申请商户成功！</span>
<div class="m-b-lg">
<div class="wrapper text-center">
<strong>以下为您的商户信息：</strong>
</div>
<form name="form" class="form-validation" method="post" action="login.php">
<div class="text-danger wrapper text-center" ng-show="authError">
</div>
<div class="list-group list-group-sm swaplogin">
<div class="list-group-item">
<div class="input-group">
<div class="input-group-addon">商户ID</div>
<input type="text" name="pid" value="<?php echo $pid?>" class="form-control no-border" disabled>
</div>
</div>
<div class="list-group-item">
<div class="input-group">
<div class="input-group-addon">商户密钥</div>
<input type="text" name="key" value="<?php echo $key?>" class="form-control no-border" disabled>
</div>
</div>
</div>
<div class="wrapper text-center">
商户信息已经发送到您的邮箱中
</div>
<a href="login.php?user=<?php echo $pid?>&pass=<?php echo $key?>" ui-sref="access.signup" class="btn btn-default btn-block">返回登录</a>
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
<script src="//cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script>
$(document).ready(function(){
	var pid=$("input[name='pid']").val();
	var key=$("input[name='key']").val();
	var mch_info = pid+"|"+key;
	$.cookie('mch_info', mch_info);
});
</script>
</body>
</html>