<?php
/**
 * 合作者列表
**/
include("../includes/common.php");
$title='合作者列表';
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
		  <li><a href="./plist.php"><span class="glyphicon glyphicon-user"></span> 商户管理</a></li>
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
<div class="panel-heading"><h3 class="panel-title">添加合作者</h3></div>';
echo '<div class="panel-body">';
echo '<form action="./plist.php?my=add_submit" method="POST">
<div class="form-group">
<label>用户名:</label><br>
<input type="text" class="form-control" name="user" value="" required>
</div>
<div class="form-group">
<label>密码:</label><br>
<input type="text" class="form-control" name="pwd" value="" required>
</div>
<div class="form-group">
<label>姓名:</label><br>
<input type="text" class="form-control" name="name" value="" placeholder="可留空">
</div>
<div class="form-group">
<label>等级:</label><br><select class="form-control" name="level"><option value="1">1_普通合作者</option><option value="2">2_高级合作者</option><option value="3">3_白金合作者</option></select>
</div>
<div class="form-group">
<label>是否激活:</label><br><select class="form-control" name="active"><option value="1">1_激活</option><option value="0">0_封禁</option></select>
</div>
<input type="submit" class="btn btn-primary btn-block"
value="确定添加"></form>';
echo '<br/><a href="./plist.php">>>返回合作者列表</a>';
echo '</div></div>';
}
elseif($my=='edit')
{
$id=$_GET['id'];
$row=$DB->query("select * from panel_user where id='$id' limit 1")->fetch();
echo '<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">修改商户信息</h3></div>';
echo '<div class="panel-body">';
echo '<form action="./plist.php?my=edit_submit&id='.$id.'" method="POST">
<div class="form-group">
<label>用户名:</label><br>
<input type="text" class="form-control" name="user" value="'.$row['user'].'" required>
</div>
<div class="form-group">
<label>密码:</label><br>
<input type="text" class="form-control" name="pwd" value="'.$row['pwd'].'" required>
</div>
<div class="form-group">
<label>姓名:</label><br>
<input type="text" class="form-control" name="name" value="'.$row['name'].'" required>
</div>
<div class="form-group">
<label>等级:</label><br><select class="form-control" name="level" default="'.$row['level'].'"><option value="1">1_普通合作者</option><option value="2">2_高级合作者</option><option value="3">3_白金合作者</option></select>
</div>
<div class="form-group">
<label>是否激活:</label><br><select class="form-control" name="active" default="'.$row['active'].'"><option value="1">1_激活</option><option value="0">0_封禁</option></select>
</div>
<div class="form-group">
<label>是否重置密钥？</label><br><select class="form-control" name="resetkey"><option value="0">0_否</option><option value="1">1_是</option></select>
</div>
<input type="submit" class="btn btn-primary btn-block"
value="确定修改"></form>
';
echo '<br/><a href="./plist.php">>>返回合作者列表</a>';
echo '</div></div>
<script>
var items = $("select[default]");
for (i = 0; i < items.length; i++) {
	$(items[i]).val($(items[i]).attr("default"));
}
</script>';
}
elseif($my=='add_submit')
{
$user=$_POST['user'];
$pwd=$_POST['pwd'];
$name=$_POST['name'];
$level=$_POST['level'];
$active=$_POST['active'];
if($user==NULL or $pwd==NULL){
showmsg('保存错误,请确保加*项都不为空!',3);
} else {
$key = md5(random(32));
$sds=$DB->exec("INSERT INTO `panel_user` (`token`, `user`, `pwd`, `name`, `level`, `regtime`, `active`) VALUES ('{$key}', '{$user}', '{$pwd}', '{$name}', '{$level}', '{$date}', '{$active}')");
$pid=$DB->lastInsertId();
if($sds){
	showmsg('添加合作者身份成功！合作者身份TOKEN：'.$key.'<br/><br/><a href="./plist.php">>>返回合作者列表</a>',1);
}else
	showmsg('添加合作者身份失败！<br/>错误信息：'.$DB->errorCode(),4);
}
}
elseif($my=='edit_submit')
{
$id=$_GET['id'];
$rows=$DB->query("select * from panel_user where id='$id' limit 1")->fetch();
if(!$rows)
	showmsg('当前记录不存在！',3);
$user=$_POST['user'];
$pwd=$_POST['pwd'];
$name=$_POST['name'];
$level=$_POST['level'];
$active=$_POST['active'];
if($user==NULL or $pwd==NULL){
showmsg('保存错误,请确保加*项都不为空!',3);
} else {
$sql="update `panel_user` set `user` ='{$user}',`pwd` ='{$pwd}',`name` ='{$name}',`level` ='{$level}',`active` ='$active' where `id`='$id'";
if($_POST['resetkey']==1){
	$key = md5(random(32));
	$sqs=$DB->exec("update `panel_user` set `token` ='{$key}' where `id`='$id'");
}
if($DB->exec($sql)||$sqs)
	showmsg('修改合作者身份信息成功！<br/><br/><a href="./plist.php">>>返回合作者列表</a>',1);
else
	showmsg('修改合作者身份信息失败！'.$DB->errorCode(),4);
}
}
elseif($my=='delete')
{
$id=$_GET['id'];
$rows=$DB->query("select * from panel_user where id='$id' limit 1")->fetch();
if(!$rows)
	showmsg('当前记录不存在！',3);
$urls=explode(',',$rows['url']);
$sql="DELETE FROM panel_user WHERE id='$id'";
if($DB->exec($sql))
	showmsg('删除合作者成功！<br/><br/><a href="./plist.php">>>返回合作者列表</a>',1);
else
	showmsg('删除合作者失败！'.$DB->errorCode(),4);
}
else
{

echo '<form action="plist.php" method="GET" class="form-inline"><input type="hidden" name="my" value="search">
  <div class="form-group">
    <label>搜索</label>
	<select name="column" class="form-control"><option value="user">用户名</option><option value="token">合作者TOKEN</option><option value="name">姓名</option></select>
  </div>
  <div class="form-group">
    <input type="text" class="form-control" name="value" placeholder="搜索内容">
  </div>
  <button type="submit" class="btn btn-primary">搜索</button>&nbsp;<a href="./plist.php?my=add" class="btn btn-success">添加商户</a>&nbsp;<a href="./ulist.php" class="btn btn-default">普通商户管理</a>
</form>';

if($my=='search') {
	$sql=" `{$_GET['column']}`='{$_GET['value']}'";
	$numrows=$DB->query("SELECT * from panel_user WHERE{$sql}")->rowCount();
	$con='包含 '.$_GET['value'].' 的共有 <b>'.$numrows.'</b> 个商户';
	$link='&my=search&column='.$_GET['column'].'&value='.$_GET['value'];
}else{
	$numrows=$DB->query("SELECT * from panel_user WHERE 1")->rowCount();
	$sql=" 1";
	$con='共有 <b>'.$numrows.'</b> 个商户';
}
echo $con;
?>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead><tr><th>ID</th><th>用户名</th><th>密码</th><th>合作者TOKEN</th><th>添加时间</th><th>等级</th><th>状态</th><th>操作</th></tr></thead>
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

$rs=$DB->query("SELECT * FROM panel_user WHERE{$sql} order by id desc limit $offset,$pagesize");
while($res = $rs->fetch())
{
echo '<tr><td><b>'.$res['id'].'</b></td><td>'.$res['user'].'</td><td>'.$res['pwd'].'</td><td>'.$res['token'].'</td><td>'.$res['regtime'].'</td><td>'.$res['level'].'</td><td>'.($res['active']==1?'<font color=green>正常</font>':'<font color=red>封禁</font>').'</td><td><a href="./plist.php?my=edit&id='.$res['id'].'" class="btn btn-xs btn-info">编辑</a>&nbsp;<a href="./plist.php?my=delete&id='.$res['id'].'" class="btn btn-xs btn-danger" onclick="return confirm(\'你确实要删除此商户吗？\');">删除</a></td></tr>';
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
echo '<li><a href="plist.php?page='.$first.$link.'">首页</a></li>';
echo '<li><a href="plist.php?page='.$prev.$link.'">&laquo;</a></li>';
} else {
echo '<li class="disabled"><a>首页</a></li>';
echo '<li class="disabled"><a>&laquo;</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li><a href="plist.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="disabled"><a>'.$page.'</a></li>';
for ($i=$page+1;$i<=$pages;$i++)
echo '<li><a href="plist.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$pages)
{
echo '<li><a href="plist.php?page='.$next.$link.'">&raquo;</a></li>';
echo '<li><a href="plist.php?page='.$last.$link.'">尾页</a></li>';
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