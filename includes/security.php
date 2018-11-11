<?php
if($_GET['rand'] && $_SESSION['cron_session']!=$_GET['rand']){
	exit('浏览器不支持COOKIE或者不正常访问！');
}
if(!$_SESSION['cron_session'] && $nosecu!=true){
	$cron_session=md5(uniqid().rand(1,1000));
	$_SESSION['cron_session']=$cron_session;
	exit("<script language='javascript'>window.location.href='?{$_SERVER['QUERY_STRING']}&rand={$cron_session}';</script>");
}
?>