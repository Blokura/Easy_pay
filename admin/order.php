<?php
/**
 * 订单列表
**/
include("../includes/common.php");
$title='订单列表';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
  <nav class="navbar navbar-fixed-top navbar-default">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">导航按钮</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="./">支付管理中心</a>
      </div><!-- /.navbar-header -->
      <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
          <li>
            <a href="./"><span class="glyphicon glyphicon-home"></span> 平台首页</a>
          </li>
		  <li class="active"><a href="./order.php"><span class="glyphicon glyphicon-shopping-cart"></span> 订单管理</a></li>
		  <li><a href="./ulist.php"><span class="glyphicon glyphicon-user"></span> 商户管理</a></li>
          <li><a href="./gg.php"><span class="glyphicon glyphicon-flag"></span> 商户公告</a></li>
          <li><a href="./login.php?logout"><span class="glyphicon glyphicon-log-out"></span> 退出登陆</a></li>
        </ul>
        <script src="https://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
        <script>function go(){$.ajax({url:"shen.php",type:"get",dataType:"json",success: function (data) {if (data.code == "200") {alert("审核成功");}else{alert("error")}}} )}</script>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
  </nav><!-- /.navbar -->
  <div class="container" style="padding-top:70px;">
    <div class="col-md-12 center-block" style="float: none;">
<?php

$my=isset($_GET['my'])?$_GET['my']:null;

echo '<form action="order.php" method="GET" class="form-inline"><input type="hidden" name="my" value="search">
  <div class="form-group">
    <label>搜索</label>
	<select name="column" class="form-control"><option value="trade_no">订单号</option><option value="out_trade_no">商户订单号</option><option value="pid">商户号</option><option value="name">商品名称</option><option value="money">金额</option></select>
  </div>
  <div class="form-group">
    <input type="text" class="form-control" name="value" placeholder="搜索内容">
  </div>
  <button type="submit" class="btn btn-primary">搜索</button>&nbsp;&nbsp;<a href="" onclick="go()" id="btn1"  class="btn btn-primary">提交审核</a>
</form>';
      

if($my=='search') {
	if($_GET['column']=='name'){
		$sql=" `{$_GET['column']}` like '%{$_GET['value']}%'";
	}else{
		$sql=" `{$_GET['column']}`='{$_GET['value']}'";
	}
	$numrows=$DB->query("SELECT count(*) from pay_order WHERE{$sql}")->fetchColumn();
	$con='包含 '.$_GET['value'].' 的共有 <b>'.$numrows.'</b> 条订单';
	$link='&my=search&column='.$_GET['column'].'&value='.$_GET['value'];
}else{
	$numrows=$DB->query("SELECT count(*) from pay_order WHERE 1")->fetchColumn();
	$sql=" 1";
	$con='共有 <b>'.$numrows.'</b> 条订单';
}
echo $con;
?>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead><tr><th>订单号/商户订单号</th><th>商户号/网站域名</th><th>商品名称/金额</th><th>支付方式</th><th>创建时间/完成时间</th><th>支付状态</th></tr></thead>
          <tbody>
<?php
$pagesize=30;
$pages=intval($numrows/$pagesize);
if ($numrows%$pagesize)
{
 $pages++;
 }
if (isset($_GET['page'])){
$page=intval($_GET['page']);
}
else{
$page=1;
}
$offset=$pagesize*($page - 1);

$rs=$DB->query("SELECT * FROM pay_order WHERE{$sql} order by trade_no desc limit $offset,$pagesize");
while($res = $rs->fetch())
{
  //定义资金状态
  $zt = $res['status'];
  $stat = '';
  if($zt == 0){
    $stat = '<font color=blue>未完成</font>';
  }elseif($zt == 1){
    $stat = '<font color=green>已完成</font>';
  }elseif($zt == 2){
	$stat = '<font color=red>待审核</font>';
  }else{
    $stat = 'error';}
    
	$url=creat_callback($res);
	$domain=!empty($res['domain'])?$res['domain']:getdomain($res['notify_url']);
	echo '<tr><td><b><a href="'.$url['notify'].'" title="支付通知" target="_blank" rel="noreferrer">'.$res['trade_no'].'</a></b><br/>'.$res['out_trade_no'].'</td><td>'.$res['pid'].'<br/>'.getdomain($res['notify_url']).'</td><td>'.$res['name'].'<br/>￥'.$res['money'].'</td><td>'.$res['type'].'</td><td>'.$res['addtime'].'<br/>'.$res['endtime'].'</td><td>'.$stat.'</td></tr>';
  //echo '<tr><td><b><a href="'.$url['notify'].'" title="支付通知" target="_blank" rel="noreferrer">'.$res['trade_no'].'</a></b><br/>'.$res['out_trade_no'].'</td><td>'.$res['pid'].'<br/>'.getdomain($res['notify_url']).'</td><td>'.$res['name'].'<br/>￥'.$res['money'].'</td><td>'.$res['type'].'</td><td>'.$res['addtime'].'<br/>'.$res['endtime'].'</td><td>'.($res['status']==1?'<font color=green>已完成</font>':'<font color=blue>未完成</font>').'</td></tr>';
}
?>
          </tbody>
        </table>
      </div>
<?php
echo'<ul class="pagination">';
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$pages;
if ($page>1)
{
echo '<li><a href="order.php?page='.$first.$link.'">首页</a></li>';
echo '<li><a href="order.php?page='.$prev.$link.'">&laquo;</a></li>';
} else {
echo '<li class="disabled"><a>首页</a></li>';
echo '<li class="disabled"><a>&laquo;</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li><a href="order.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="disabled"><a>'.$page.'</a></li>';
if($pages>=10)$s=10;
else $s=$pages;
for ($i=$page+1;$i<=$s;$i++)
echo '<li><a href="order.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$pages)
{
echo '<li><a href="order.php?page='.$next.$link.'">&raquo;</a></li>';
echo '<li><a href="order.php?page='.$last.$link.'">尾页</a></li>';
} else {
echo '<li class="disabled"><a>&raquo;</a></li>';
echo '<li class="disabled"><a>尾页</a></li>';
}
echo'</ul>';
#分页
?>
    </div>
  </div>