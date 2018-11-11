<?php
require './includes/common.php';

@header('Content-Type: text/html; charset=UTF-8');

$trade_no=daddslashes($_GET['trade_no']);
$sitename=base64_decode(daddslashes($_GET['sitename']));
$row=$DB->query("SELECT * FROM pay_order WHERE trade_no='{$trade_no}' limit 1")->fetch();
if(!$row)sysmsg('该订单号不存在，请返回来源地重新发起请求！');

if(isset($_GET['type']))$DB->query("update `pay_order` set `type` ='wxpay',`addtime` ='$date' where `trade_no`='$trade_no'");

$name = 'onlinepay-'.time();
require_once SYSTEM_ROOT."wxpay/WxPay.Api.php";
require_once SYSTEM_ROOT."wxpay/WxPay.NativePay.php";
$notify = new NativePay();
$input = new WxPayUnifiedOrder();
$input->SetBody($name);
$input->SetOut_trade_no($trade_no);
$input->SetTotal_fee($row['money']*100);
$input->SetSpbill_create_ip($clientip);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("test");
$input->SetNotify_url('http://'.$conf['local_domain'].'/wxpay_notify.php');
$input->SetTrade_type("MWEB");
$result = $notify->GetPayUrl($input);
if($result["result_code"]=='SUCCESS'){
	$redirect_url='http://'.$_SERVER['HTTP_HOST'].'/wxwap_return.php?trade_no='.$trade_no;
	$url=$result['mweb_url'].'&redirect_url='.urlencode($redirect_url);
	exit("<script>window.location.replace('{$url}');</script>");
}else{
	sysmsg('微信支付下单失败！['.$result["err_code"].'] '.$result["err_code_des"]);
}

$target_url = 'http://'.$_SERVER['HTTP_HOST'].'/wxjspay.php?trade_no='.$trade_no;
?>
<html lang="zh-cn">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>微信安全支付</title>
  <link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>

<div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 center-block" style="float: none;">
<div class="panel panel-primary">
	<div class="panel-heading" style="text-align: center;"><h3 class="panel-title">
		微信安全支付
	</div>
		<div class="list-group" style="text-align: center;">
			<div class="list-group-item list-group-item-info">请使用微信扫一扫 扫描二维码完成支付</div>
			<div class="list-group-item">
			<div class="qr-image" id="qrcode"></div>
			</div>
			<div class="list-group-item list-group-item-info">或复制以下链接到微信打开：</div>
			<div class="list-group-item">
			<a href="<?php echo $target_url?>"><?php echo $target_url?></a>
			</div>
			<div class="list-group-item"><small>提示：你可以将以上链接发到自己微信的聊天框（在微信顶部搜索框可以搜到自己的微信），即可点击进入支付</small></div>
			<div class="list-group-item">支付成功请返回当前页面查看结果</div>
		</div>
</div>
</div>
<script src="assets/js/qrcode.min.js"></script>
<script src="assets/js/qcloud_util.js"></script>
<script src="assets/layer/layer.js"></script>
<script>
	var qrcode = new QRCode("qrcode", {
        text: "<?php echo $target_url?>",
        width: 230,
        height: 230,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
    });
    // 检查是否支付完成
    function loadmsg() {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "getshop.php",
            timeout: 10000, //ajax请求超时时间10s
            data: {type: "wxpay", trade_no: "<?php echo $row['trade_no']?>"}, //post数据
            success: function (data, textStatus) {
                //从服务器得到数据，显示数据并继续查询
                if (data.code == 1) {
					layer.msg('支付成功，正在跳转中...', {icon: 16,shade: 0.01,time: 15000});
					setTimeout(window.location.href=data.backurl, 1000);
                }else{
                    setTimeout("loadmsg()", 4000);
                }
            },
            //Ajax请求超时，继续查询
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                if (textStatus == "timeout") {
                    setTimeout("loadmsg()", 1000);
                } else { //异常
                    setTimeout("loadmsg()", 4000);
                }
            }
        });
    }
    window.onload = loadmsg();
</script>
</body>
</html>