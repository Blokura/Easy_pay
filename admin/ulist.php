<?php
/**
 * 商户列表
**/
include("../includes/common.php");
$title='商户列表';
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
		  <li><a href="./order.php"><span class="glyphicon glyphicon-shopping-cart"></span> 订单管理</a></li>
		  <li class="active"><a href="./ulist.php"><span class="glyphicon glyphicon-user"></span> 商户管理</a></li>
          <li><a href="./gg.php"><span class="glyphicon glyphicon-flag"></span> 商户公告</a></li>
          <li><a href="./login.php?logout"><span class="glyphicon glyphicon-log-out"></span> 退出登陆</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
  </nav><!-- /.navbar -->
  <div class="container" style="padding-top:70px;">
    <div class="col-md-12 center-block" style="float: none;">
<?php

$my=isset($_GET['my'])?$_GET['my']:null;

if($my=='add')
{
echo '<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">添加商户</h3></div>';
echo '<div class="panel-body">';
echo '<form action="./ulist.php?my=add_submit" method="POST">
<div class="form-group">
<label>结算方式:</label><br><select class="form-control" name="settle_id">
'.($conf['stype_1']?'<option value="1">支付宝</option>':null).'
'.($conf['stype_2']?'<option value="2">微信</option>':null).'
'.($conf['stype_3']?'<option value="3">QQ钱包</option>':null).'
'.($conf['stype_4']?'<option value="4">银行卡</option>':null).'
</select>
</div>
<div class="form-group">
<label>结算账号:</label><br>
<input type="text" class="form-control" name="account" value="" required>
</div>
<div class="form-group">
<label>结算账号姓名:</label><br>
<input type="text" class="form-control" name="username" value="" required>
</div>
<div class="form-group">
<label>网站域名:</label><br>
<input type="text" class="form-control" name="url" value="" placeholder="可留空">
</div>
<div class="form-group">
<label>邮箱:</label><br>
<input type="text" class="form-control" name="email" value="" placeholder="可留空">
</div>
<div class="form-group">
<label>ＱＱ:</label><br>
<input type="text" class="form-control" name="qq" value="" placeholder="可留空">
</div>
<div class="form-group">
<label>自定义分成比例:</label><br>
<input type="text" class="form-control" name="rate" value="" placeholder="填写百分数，例如98.5">
</div>
<div class="form-group">
<label>是否结算:</label><br><select class="form-control" name="type"><option value="1">1_是</option><option value="2">2_否</option></select>
</div>
<div class="form-group">
<label>是否激活:</label><br><select class="form-control" name="active"><option value="1">1_激活</option><option value="0">0_封禁</option></select>
</div>
<input type="submit" class="btn btn-primary btn-block"
value="确定添加"></form>';
echo '<br/><a href="./ulist.php">>>返回商户列表</a>';
echo '</div></div>';
}
elseif($my=='edit')
{
$id=$_GET['id'];
$row=$DB->query("select * from pay_user where id='$id' limit 1")->fetch();
echo '<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">修改商户信息</h3></div>';
echo '<div class="panel-body">';
echo '<form action="./ulist.php?my=edit_submit&id='.$id.'" method="POST">
<div class="form-group">
<label>结算方式:</label><br><select class="form-control" name="settle_id" default="'.$row['settle_id'].'">
'.($conf['stype_1']?'<option value="1">支付宝</option>':null).'
'.($conf['stype_2']?'<option value="2">微信</option>':null).'
'.($conf['stype_3']?'<option value="3">QQ钱包</option>':null).'
'.($conf['stype_4']?'<option value="4">银行卡</option>':null).'
</select>
</div>
<div class="form-group">
<label>结算账号:</label><br>
<input type="text" class="form-control" name="account" value="'.$row['account'].'" required>
</div>
<div class="form-group">
<label>结算账号姓名:</label><br>
<input type="text" class="form-control" name="username" value="'.$row['username'].'" required>
</div>
<div class="form-group">
<label>商户余额:</label><br>
<input type="text" class="form-control" name="money" value="'.$row['money'].'" required>
</div>
<div class="form-group">
<label>网站域名:</label><br>
<input type="text" class="form-control" name="url" value="'.$row['url'].'" placeholder="可留空">
</div>
<div class="form-group">
<label>邮箱:</label><br>
<input type="text" class="form-control" name="email" value="'.$row['email'].'" placeholder="可留空">
</div>
<div class="form-group">
<label>ＱＱ:</label><br>
<input type="text" class="form-control" name="qq" value="'.$row['qq'].'" placeholder="可留空">
</div>
<div class="form-group">
<label>自定义分成比例:</label><br>
<input type="text" class="form-control" name="rate" value="'.$row['rate'].'" placeholder="填写百分数，例如98.5">
</div>
<div class="form-group">
<label>是否结算:</label><br><select class="form-control" name="type" default="'.$row['type'].'"><option value="1">1_是</option><option value="2">2_否</option></select>
</div>
<div class="form-group">
<label>是否激活:</label><br><select class="form-control" name="active" default="'.$row['active'].'"><option value="1">1_激活</option><option value="0">0_封禁</option></select>
</div>
<div class="form-group">
<label>是否重置密钥？</label><br><select class="form-control" name="resetkey"><option value="0">0_否</option><option value="1">1_是</option></select>
</div>
<input type="submit" class="btn btn-primary btn-block" value="确定修改"></form>
';
echo '<br/><a href="./ulist.php">>>返回商户列表</a>';
echo '</div></div>
<script>
var items = $("select[default]");
for (i = 0; i < items.length; i++) {
	$(items[i]).val($(items[i]).attr("default")||0);
}
</script>';
}
elseif($my=='add_submit')
{
$settle_id=$_POST['settle_id'];
$account=$_POST['account'];
$username=$_POST['username'];
$money='0.00';
$url=$_POST['url'];
$email=$_POST['email'];
$qq=$_POST['qq'];
$type=$_POST['type'];
$rate=$_POST['rate'];
$active=$_POST['active'];
if($account==NULL or $username==NULL){
showmsg('保存错误,请确保加*项都不为空!',3);
} else {
$key = random(32);
$sds=$DB->exec("INSERT INTO `pay_user` (`key`, `account`, `username`, `money`, `url`, `addtime`, `type`, `settle_id`, `email`, `qq`, `rate`, `active`) VALUES ('{$key}', '{$account}', '{$username}', '{$money}', '{$url}', '{$date}', '{$type}', '{$settle_id}', '{$email}', '{$qq}', '{$rate}', '{$active}')");
$pid=$DB->lastInsertId();
if($sds){
	showmsg('添加商户成功！商户ID：'.$pid.'<br/>密钥：'.$key.'<br/><br/><a href="./ulist.php">>>返回商户列表</a>',1);
}else
	showmsg('添加商户失败！<br/>错误信息：'.$DB->errorCode(),4);
}
}
elseif($my=='edit_submit')
{
$id=$_GET['id'];
$rows=$DB->query("select * from pay_user where id='$id' limit 1")->fetch();
if(!$rows)
	showmsg('当前记录不存在！',3);
$settle_id=$_POST['settle_id'];
$account=$_POST['account'];
$username=$_POST['username'];
$money=$_POST['money'];
$url=$_POST['url'];
$email=$_POST['email'];
$qq=$_POST['qq'];
$type=$_POST['type'];
$rate=$_POST['rate'];
$active=$_POST['active'];
if($account==NULL or $username==NULL){
showmsg('保存错误,请确保加*项都不为空!',3);
} else {
$sql="update `pay_user` set `account` ='{$account}',`username` ='{$username}',`money` ='{$money}',`url` ='{$url}',`type` ='$type',`settle_id` ='$settle_id',`email` ='$email',`qq` ='$qq',`rate` ='$rate',`active` ='$active' where `id`='$id'";
if($_POST['resetkey']==1){
	$key = random(32);
	$sqs=$DB->exec("update `pay_user` set `key` ='{$key}' where `id`='$id'");
}
if($DB->exec($sql)||$sqs)
	showmsg('修改商户信息成功！<br/><br/><a href="./ulist.php">>>返回商户列表</a>',1);
else
	showmsg('修改商户信息失败！'.$DB->errorCode(),4);
}
}
elseif($my=='delete')
{
$id=$_GET['id'];
$rows=$DB->query("select * from pay_user where id='$id' limit 1")->fetch();
if(!$rows)
	showmsg('当前记录不存在！',3);
$urls=explode(',',$rows['url']);
$sql="DELETE FROM pay_user WHERE id='$id'";
if($DB->exec($sql))
	showmsg('删除商户成功！<br/><br/><a href="./ulist.php">>>返回商户列表</a>',1);
else
	showmsg('删除商户失败！'.$DB->errorCode(),4);
}
else
{

echo '<form action="ulist.php" method="GET" class="form-inline"><input type="hidden" name="my" value="search">
  <div class="form-group">
    <label>搜索</label>
	<select name="column" class="form-control"><option value="id">商户号</option><option value="key">密钥</option><option value="account">结算账号</option><option value="username">结算姓名</option><option value="url">域名</option><option value="qq">QQ</option><option value="phone">手机号码</option><option value="email">邮箱</option></select>
  </div>
  <div class="form-group">
    <input type="text" class="form-control" name="value" placeholder="搜索内容">
  </div>
  <button type="submit" class="btn btn-primary">搜索</button>&nbsp;<a href="./ulist.php?my=add" class="btn btn-success">添加商户</a>&nbsp;<a href="./plist.php" class="btn btn-default">合作者商户管理</a>
</form>';

if($my=='search') {
	$sql=" `{$_GET['column']}`='{$_GET['value']}'";
	$numrows=$DB->query("SELECT * from pay_user WHERE{$sql}")->rowCount();
	$con='包含 '.$_GET['value'].' 的共有 <b>'.$numrows.'</b> 个商户';
}else{
	$numrows=$DB->query("SELECT * from pay_user WHERE 1")->rowCount();
	$sql=" 1";
	$con='共有 <b>'.$numrows.'</b> 个商户';
}
echo $con;
?>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead><tr><th>商户号</th><th>密钥</th><th>余额</th><th>结算账号/姓名</th><th>实名状态</th><th>域名/添加时间</th><th>状态</th><th>操作</th></tr></thead>
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

$rs=$DB->query("SELECT * FROM pay_user WHERE{$sql} order by id desc limit $offset,$pagesize");
while($res = $rs->fetch())
{
  //定义字段是否
  $sm = $res['shiming'];
  $s = '';
  if($sm == 0){
  $s = '未实名';
  }elseif($sm == 1){
  $s = '已实名';
  }else{
  $s = 'error';} 
echo '<tr><td><b>'.$res['id'].'</b></td><td>'.$res['key'].'</td><td>'.$res['money'].'</td><td>'.($res['settle_id']==2?'<font color="green">WX:</font>':null).($res['settle_id']==3?'<font color="green">QQ:</font>':null).$res['account'].'<br/>'.$res['username'].'</td><td>'.$s.'</td><td>'.$res['url'].'<br/>'.$res['addtime'].'</td><td>'.($res['active']==1?'<font color=green>正常</font>':'<font color=red>封禁</font>').'</td><td><a href="./ulist.php?my=edit&id='.$res['id'].'" class="btn btn-xs btn-info">编辑</a>&nbsp;<a href="./ulist.php?my=delete&id='.$res['id'].'" class="btn btn-xs btn-danger" onclick="return confirm(\'你确实要删除此商户吗？\');">删除</a></td></tr>';
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
echo '<li><a href="ulist.php?page='.$first.$link.'">首页</a></li>';
echo '<li><a href="ulist.php?page='.$prev.$link.'">&laquo;</a></li>';
} else {
echo '<li class="disabled"><a>首页</a></li>';
echo '<li class="disabled"><a>&laquo;</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li><a href="ulist.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="disabled"><a>'.$page.'</a></li>';
for ($i=$page+1;$i<=$pages;$i++)
echo '<li><a href="ulist.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$pages)
{
echo '<li><a href="ulist.php?page='.$next.$link.'">&raquo;</a></li>';
echo '<li><a href="ulist.php?page='.$last.$link.'">尾页</a></li>';
} else {
echo '<li class="disabled"><a>&raquo;</a></li>';
echo '<li class="disabled"><a>尾页</a></li>';
}
echo'</ul>';
#分页
}
?>
    </div>
  </div>