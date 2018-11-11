<?php

include("../includes/common.php");

if($conf['is_reg']==0)sysmsg('未开放商户申请');
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title>申请商户 | <?php echo $conf['web_name']?></title>
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
<strong>自助申请商户</strong>
</div>
<form name="form" class="form-validation">
<?php if($conf['is_payreg']){?><div class="wrapper">商户申请价格为：<b><?php echo $conf['reg_price']?></b>元</div><?php }?>
<div class="list-group list-group-sm swaplogin">
<div class="list-group-item">
<select class="form-control" name="type">
<?php if($conf['stype_1']){?><option value="1">支付宝结算</option>
<?php }if($conf['stype_2']){?><option value="2">微信结算</option>
<?php }if($conf['stype_3']){?><option value="3">QQ钱包结算</option>
<?php }if($conf['stype_4']){?><option value="4">银行卡结算</option>
<?php }?></select>
</div>
<div class="list-group-item">
<input type="text" name="account" placeholder="结算账号" class="form-control no-border" required>
</div>
<div class="list-group-item">
<input type="text" name="username" placeholder="真实姓名" class="form-control no-border" required>
</div>
<div class="list-group-item">
<input type="text" name="url" placeholder="你的网站域名" class="form-control no-border" required>
</div>
<div class="list-group-item">
<input type="email" name="email" placeholder="邮箱（用于接收商户信息）" class="form-control no-border" required>
</div>
<?php if($conf['verifytype']==1){?>
<div class="list-group-item">
<input type="text" name="phone" placeholder="手机号码" class="form-control no-border" required>
</div>
<div class="list-group-item">
<div class="input-group">
<input type="text" name="code" placeholder="短信验证码" class="form-control no-border" required>
<a class="input-group-addon" id="sendsms">获取验证码</a>
</div>
</div>
<div id="embed-captcha"></div>
<?php }else{?>
<div class="list-group-item">
<div class="input-group">
<input type="text" name="code" placeholder="验证码" class="form-control no-border" required>
<a class="input-group-addon" id="sendcode">获取验证码</a>
</div>
</div>
<?php }?>
<div class="checkbox m-b-md m-t-none">
<label class="i-checks">
  <input type="checkbox" ng-model="agree" checked required><i></i> 同意<a href="agreement.html" target="_blank">我们的条款</a>
</label>
</div>
</div>
<button type="button" id="submit" class="btn btn-lg btn-primary btn-block" ng-click="login()" ng-disabled='form.$invalid'>立即注册</button>
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
<script src="//cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script src="../assets/layer/layer.js"></script>
<script src="//static.geetest.com/static/tools/gt.js"></script>
<script>
function invokeSettime(obj){
    var countdown=60;
    settime(obj);
    function settime(obj) {
        if (countdown == 0) {
            $(obj).attr("data-lock", "false");
            $(obj).text("获取验证码");
            countdown = 60;
            return;
        } else {
			$(obj).attr("data-lock", "true");
            $(obj).attr("disabled",true);
            $(obj).text("(" + countdown + ") s 重新发送");
            countdown--;
        }
        setTimeout(function() {
                    settime(obj) }
                ,1000)
    }
}
var handlerEmbed = function (captchaObj) {
	var phone;
	captchaObj.onReady(function () {
		$("#wait").hide();
	}).onSuccess(function () {
		var result = captchaObj.getValidate();
		if (!result) {
			return alert('请完成验证');
		}
		var ii = layer.load(2, {shade:[0.1,'#fff']});
		$.ajax({
			type : "POST",
			url : "ajax.php?act=sendsms",
			data : {phone:phone,geetest_challenge:result.geetest_challenge,geetest_validate:result.geetest_validate,geetest_seccode:result.geetest_seccode},
			dataType : 'json',
			success : function(data) {
				layer.close(ii);
				if(data.code == 0){
					new invokeSettime("#sendsms");
					layer.msg('发送成功，请注意查收！');
				}else{
					layer.alert(data.msg);
					captchaObj.reset();
				}
			} 
		});
	});
	$('#sendsms').click(function () {
		if ($(this).attr("data-lock") === "true") return;
		phone=$("input[name='phone']").val();
		if(phone==''){layer.alert('手机号码不能为空！');return false;}
		if(phone.length!=11){layer.alert('手机号码不正确！');return false;}
		captchaObj.verify();
	})
	// 更多接口参考：http://www.geetest.com/install/sections/idx-client-sdk.html
};
$(document).ready(function(){
	$("select[name='type']").change(function(){
		if($(this).val() == 1){
			$("input[name='account']").attr("placeholder","支付宝账号");
		}else if($(this).val() == 2){
			$("input[name='account']").attr("placeholder","微信号");
		}else if($(this).val() == 3){
			$("input[name='account']").attr("placeholder","QQ号");
		}else if($(this).val() == 4){
			$("input[name='account']").attr("placeholder","银行卡号");
		}
	});
	$("select[name='type']").change();
	if($.cookie('mch_info')){
		var data = $.cookie('mch_info').split("|");
		layer.open({
		  type: 1,
		  title: '你之前申请的商户',
		  skin: 'layui-layer-rim',
		  content: '<li class="list-group-item"><b>商户ID：</b>'+data[0]+'</li><li class="list-group-item"><b>商户密钥：</b>'+data[1]+'</li><li class="list-group-item"><a href="login.php?user='+data[0]+'&pass='+data[1]+'" class="btn btn-default btn-block">返回登录</a></li>'
		});
	}
	$("#sendcode").click(function(){
		if ($(this).attr("data-lock") === "true") return;
		var email=$("input[name='email']").val();
		if(email==''){layer.alert('邮箱不能为空！');return false;}
		var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
		if(!reg.test(email)){layer.alert('邮箱格式不正确！');return false;}
		var ii = layer.load(2, {shade:[0.1,'#fff']});
		$.ajax({
			type : "POST",
			url : "ajax.php?act=sendcode",
			data : {email:email},
			dataType : 'json',
			success : function(data) {
				layer.close(ii);
				if(data.code == 0){
					new invokeSettime("#sendcode");
					layer.msg('发送成功，请注意查收！');
				}else{
					layer.alert(data.msg);
				}
			} 
		});
	});
	$("#submit").click(function(){
		if ($(this).attr("data-lock") === "true") return;
		var type=$("select[name='type']").val();
		var account=$("input[name='account']").val();
		var username=$("input[name='username']").val();
		var url=$("input[name='url']").val();
		var email=$("input[name='email']").val();
		var phone=$("input[name='phone']").val();
		var code=$("input[name='code']").val();
		if(account=='' || username=='' || url=='' || email=='' || phone=='' || code==''){layer.alert('请确保各项不能为空！');return false;}
		var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
		if(!reg.test(email)){layer.alert('邮箱格式不正确！');return false;}
		if (url.indexOf(" ")>=0){
			url = url.replace(/ /g,"");
		}
		if (url.toLowerCase().indexOf("http://")==0){
			url = url.slice(7);
		}
		if (url.toLowerCase().indexOf("https://")==0){
			url = url.slice(8);
		}
		if (url.slice(url.length-1)=="/"){
			url = url.slice(0,url.length-1);
		}
		$("input[name='url']").val(url);
		var ii = layer.load(2, {shade:[0.1,'#fff']});
		$(this).attr("data-lock", "true");
		$.ajax({
			type : "POST",
			url : "ajax.php?act=reg",
			data : {type:type,account:account,username:username,url:url,email:email,phone:phone,code:code},
			dataType : 'json',
			success : function(data) {
				$("#submit").attr("data-lock", "false");
				layer.close(ii);
				if(data.code == 1){
					layer.open({
					  type: 1,
					  title: '商户申请成功',
					  skin: 'layui-layer-rim',
					  content: '<li class="list-group-item"><b>商户ID：</b>'+data.pid+'</li><li class="list-group-item"><b>商户密钥：</b>'+data.key+'</li><li class="list-group-item">以上商户信息已经发送到您的邮箱中</li><li class="list-group-item"><a href="login.php?user='+data.pid+'&pass='+data.key+'" class="btn btn-default btn-block">返回登录</a></li>'
					});
					var mch_info = data.pid+"|"+data.key;
					$.cookie('mch_info', mch_info);
				}else if(data.code == 2){
					layer.open({
					  type: 1,
					  title: '支付确认页面',
					  skin: 'layui-layer-rim',
					  content: '<li class="list-group-item"><b>所需支付金额：</b>'+data.need+'元</li><li class="list-group-item text-center"><a href="../submit2.php?type=alipay&trade_no='+data.trade_no+'" class="btn btn-default"><img src="../assets/icon/alipay.ico" class="logo">支付宝</a>&nbsp;<a href="../submit2.php?type=wxpay&trade_no='+data.trade_no+'" class="btn btn-default"><img src="../assets/icon/wechat.ico" class="logo">微信支付</a>&nbsp;<a href="../submit2.php?type=qqpay&trade_no='+data.trade_no+'" class="btn btn-default"><img src="../assets/icon/qqpay.ico" class="logo">QQ钱包</a>&nbsp;<a href="../submit2.php?type=tenpay&trade_no='+data.trade_no+'" class="btn btn-default"><img src="../assets/icon/tenpay.ico" class="logo">财付通</a></li><li class="list-group-item">提示：支付完成后请勿关闭网页，才能显示商户注册成功信息</li>'
					});
				}else{
					layer.alert(data.msg);
				}
			}
		});
	});
	$.ajax({
		// 获取id，challenge，success（是否启用failback）
		url: "ajax.php?act=captcha&t=" + (new Date()).getTime(), // 加随机数防止缓存
		type: "get",
		dataType: "json",
		success: function (data) {
			console.log(data);
			// 使用initGeetest接口
			// 参数1：配置参数
			// 参数2：回调，回调的第一个参数验证码对象，之后可以使用它做appendTo之类的事件
			initGeetest({
				width: '100%',
				gt: data.gt,
				challenge: data.challenge,
				new_captcha: data.new_captcha,
				product: "bind", // 产品形式，包括：float，embed，popup。注意只对PC版验证码有效
				offline: !data.success // 表示用户后台检测极验服务器是否宕机，一般不需要关注
				// 更多配置参数请参见：http://www.geetest.com/install/sections/idx-client-sdk.html#config
			}, handlerEmbed);
		}
	});
});
</script>
</body>
</html>