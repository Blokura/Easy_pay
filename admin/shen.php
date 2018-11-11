<?php
/**
 * 订单列表
**/
include("../includes/common.php");
$title='订单审核中';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");

$DB->query("update `pay_order` set `status` ='1' where `status`='2'");


$arr1 = array();
$arr1["code"] = "200";
echo json_encode($arr1);

?>

