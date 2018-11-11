<?php
/**
 * 订单列表
**/
include("../includes/common.php");
$title='商户公告';
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
		  <li><a href="./ulist.php"><span class="glyphicon glyphicon-user"></span> 商户管理</a></li>
          <li class="active"><a href="./gg.php"><span class="glyphicon glyphicon-flag"></span> 商户公告</a></li>
          <li><a href="./login.php?logout"><span class="glyphicon glyphicon-log-out"></span> 退出登陆</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
  </nav><!-- /.navbar -->
  <div class="container" style="padding-top:70px;">
    <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
      
      <?php 
if(isset($_POST['submit'])) {
        $value=$_POST['gg'];
        $DB->query("update `gg` set `gg` ='{$value}'");
        showmsg('修改成功！',1);
        exit();
}
?>
      
      <div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title">网站公告设置</h3></div>
<div class="panel-body">
  <form action="" method="post" class="form-horizontal" role="form">
  
    
       
  <div class="form-group">
    <label class="col-sm-2 control-label">公告内容:</label>
    <div class="col-sm-10">
              <textarea name="gg" rows="5" class="form-control" placeholder="公告支持html语法，新编辑的公告会覆盖旧公告"></textarea>
          </div>
        
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10"><input type="submit" name="submit" value="保存修改" class="btn btn-default form-control"/><br/>
   </div>
  </div>
      
  </form>
  
</div>
</div>

       

    </div>
  </div>