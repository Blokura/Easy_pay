<?php

include("../includes/common.php");
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");

require_once SYSTEM_ROOT."wxpay/WxPay.Api.php";

$id = isset($_POST['id'])?intval($_POST['id']):exit('{"code":-1,"msg":"ID不能为空"}');

$row=$DB->query("SELECT * FROM pay_settle WHERE id='{$id}' limit 1")->fetch();

if(!$row)exit('{"code":-1,"msg":"记录不存在"}');

if($row['type']!=2)exit('{"code":-1,"msg":"该记录不是微信结算"}');

if($row['transfer_status']==1)exit('{"code":0,"ret":2,"result":"微信订单号:'.$row['transfer_result'].' 支付时间:'.$row['transfer_date'].'"}');

$out_biz_no = date("Ymd").'000'.$id;

$input = new WxPayTransfer();
$input->SetPartner_trade_no($out_biz_no);
$input->SetOpenid($row['account']);
$input->SetCheck_name('FORCE_CHECK');
$input->SetRe_user_name($row['username']);
$input->SetAmount($row['money']*100);
$input->SetDesc($conf['wxtransfer_desc']);
$input->SetSpbill_create_ip($_SERVER['SERVER_ADDR']);
$result = WxPayApi::transfer($input);

if($result["result_code"]=='SUCCESS'){
$data['code']=0;
$data['ret']=1;
$data['msg']='success';
$data['result']='微信订单号:'.$result["payment_no"].' 支付时间:'.$result["payment_time"];
$DB->exec("update `pay_settle` set `transfer_status`='1',`transfer_result`='".$result["payment_no"]."',`transfer_date`='".$result["payment_time"]."' where `id`='$id'");
} elseif($result["result_code"]=='FAIL' && ($result["err_code"]=='OPENID_ERROR'||$result["err_code"]=='NAME_MISMATCH'||$result["err_code"]=='MONEY_LIMIT'||$result["err_code"]=='V2_ACCOUNT_SIMPLE_BAN')) {
$data['code']=0;
$data['ret']=0;
$data['msg']='fail';
$data['result']='失败 ['.$result["err_code"].']'.$result["err_code_des"];
$DB->exec("update `pay_settle` set `transfer_status`='2',`transfer_result`='".$data['result']."' where `id`='$id'");} elseif(!empty($result["result_code"])){
$data['code']=-1;
$data['msg']='['.$result["err_code"].']'.$result["err_code_des"];
} else {
$data['code']=-1;
$data['msg']='未知错误 '.$result["return_msg"];
}
echo json_encode($data);
