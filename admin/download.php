<?php
include("../includes/common.php");

if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");

$batch=$_GET['batch'];
$allmoney=$_GET['allmoney'];
$data='';
$rs=$DB->query("SELECT * from pay_settle where batch='$batch'");

function display_type($type){
	if($type==1)
		return '֧����';
	elseif($type==2)
		return '΢��';
	elseif($type==3)
		return 'QQǮ��';
	elseif($type==4)
		return '���п�';
	else
		return 1;
}

$i=0;
while($row = $rs->fetch())
{
	$i++;
	$data.=$i.','.display_type($row['type']).','.$row['account'].','.mb_convert_encoding($row['username'], "GB2312", "UTF-8").','.$row['money'].',�ʺ���֧���Զ�����'."\r\n";
}

$date=date("Ymd");
$file="�̻���ˮ��,�տʽ,�տ��˺�,�տ�������,�����Ԫ��,��������\r\n";
$file.=$data;

$file_name='pay_'.date("YmdHis").'.csv';
$file_size=strlen($file);
header("Content-Description: File Transfer");
header("Content-Type:application/force-download");
header("Content-Length: {$file_size}");
header("Content-Disposition:attachment; filename={$file_name}");
echo $file;
?>