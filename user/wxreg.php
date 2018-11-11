<?php
/**
 * 微信登录
**/
include("../includes/common.php");

if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')!==false){
require_once SYSTEM_ROOT."wxpay/WxPay.Api.php";
require_once SYSTEM_ROOT."wxpay/WxPay.JsApiPay.php";

$tools = new JsApiPay();
$openId = $tools->GetOpenid();

if(!$openId)sysmsg('OpenId获取失败');

header("Location: reg.php?do=wx&openid=".$openId);
exit;
}

$code_url = 'https://w.url.cn/s/Ay0emSP';
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title>微信注册商户 | <?php echo $conf['web_name']?></title>
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
<strong>请用微信扫描以下二维码继续注册商户</strong>
</div>
<form name="form" class="form-validation">
<div class="qr-image text-center" id="qrcode">
</div><br/>
<p>
或复制链接到微信打开：<a href="<?php echo $code_url?>"><?php echo $code_url?></a>
</p>
</div>
<a href="reg.php" ui-sref="access.signup" class="btn btn-lg btn-default btn-block">返回</a>
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
<script src="../assets/js/qrcode.min.js"></script>
<script>
$(document).ready(function(){
	var qrcode = new QRCode("qrcode", {
        text: "<?php echo $code_url?>",
        width: 160,
        height: 160,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
    });
});
</script>
</body>
</html>