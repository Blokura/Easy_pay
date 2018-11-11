<?php

include("../includes/common.php");
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");

require_once SYSTEM_ROOT."f2fpay/lib/AopClient.php";
require_once SYSTEM_ROOT."f2fpay/model/request/AlipayFundTransToaccountTransferRequest.php";

if(isset($_SESSION['privatekey'])){}else exit('{"code":-1,"msg":"PrivateKey未定义"}');

$id = isset($_POST['id'])?intval($_POST['id']):exit('{"code":-1,"msg":"ID不能为空"}');

$row=$DB->query("SELECT * FROM pay_settle WHERE id='{$id}' limit 1")->fetch();

if(!$row)exit('{"code":-1,"msg":"记录不存在"}');

if($row['type']!=1)exit('{"code":-1,"msg":"该记录不是支付宝结算"}');

if($row['transfer_status']==1)exit('{"code":0,"ret":2,"result":"支付宝转账单据号:'.$row['transfer_result'].' 支付时间:'.$row['transfer_date'].'"}');

$out_biz_no = date("Ymd").'000'.$id;

$BizContent = array(
	'out_biz_no' => $out_biz_no, //商户转账唯一订单号
	'payee_type' => 'ALIPAY_LOGONID', //收款方账户类型
	'payee_account' => $row['account'], //收款方账户
	'amount' => $row['money'], //转账金额
	'payer_show_name' => $conf['payer_show_name'], //付款方显示姓名
	'payee_real_name' => $row['username'], //收款方真实姓名
);

$aop = new AopClient ();
$aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
$aop->appId = $conf['alipay_appid'];
$aop->rsaPrivateKey = $_SESSION['privatekey'];
$aop->alipayrsaPublicKey='MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDDI6d306Q8fIfCOaTXyiUeJHkrIvYISRcc73s3vF1ZT7XN8RNPwJxo8pWaJMmvyTn9N4HQ632qJBVHf8sxHi/fEsraprwCtzvzQETrNRwVxLO5jVmRGi60j8Ue1efIlzPXV9je9mkjzOmdssymZkh2QhUrCmZYI/FCEa3/cNMW0QIDAQAB';
$aop->apiVersion = '1.0';
$aop->signType = 'RSA';
$aop->postCharset='UTF-8';
$aop->format='json';
$request = new AlipayFundTransToaccountTransferRequest ();
$request->setBizContent(json_encode($BizContent));
$result = $aop->execute ( $request); 

$data = array();
$responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
$resultCode = $result->$responseNode->code;
if(!empty($resultCode)&&$resultCode == 10000){
$data['code']=0;
$data['ret']=1;
$data['msg']='success';
$data['result']='支付宝转账单据号:'.$result->$responseNode->order_id.' 支付时间:'.$result->$responseNode->pay_date;
$DB->exec("update `pay_settle` set `transfer_status`='1',`transfer_result`='".$result->$responseNode->order_id."',`transfer_date`='".$result->$responseNode->pay_date."' where `id`='$id'");
} elseif($resultCode == 40004) {
$data['code']=0;
$data['ret']=0;
$data['msg']='fail';
$data['result']='失败 ['.$result->$responseNode->sub_code.']'.$result->$responseNode->sub_msg;
$DB->exec("update `pay_settle` set `transfer_status`='2',`transfer_result`='".$data['result']."' where `id`='$id'");} elseif(!empty($resultCode)){
$data['code']=-1;
$data['msg']='['.$result->$responseNode->sub_code.']'.$result->$responseNode->sub_msg;
} else {
$data['code']=-1;
$data['msg']='未知错误';
}
echo json_encode($data);
