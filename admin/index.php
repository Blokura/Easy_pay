<?php
include("../includes/common.php");
$title='支付管理中心';
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
          <li class="active">
            <a href="./"><span class="glyphicon glyphicon-home"></span> 平台首页</a>
          </li>
		  <li><a href="./order.php"><span class="glyphicon glyphicon-shopping-cart"></span> 订单管理</a></li>
		  <li><a href="./ulist.php"><span class="glyphicon glyphicon-user"></span> 商户管理</a></li>
          <li><a href="./gg.php"><span class="glyphicon glyphicon-flag"></span> 商户公告</a></li>
          <li><a href="./login.php?logout"><span class="glyphicon glyphicon-log-out"></span> 退出登陆</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
  </nav><!-- /.navbar -->
<?php
$count1=$DB->query("SELECT count(*) from pay_order")->fetchColumn();
$count2=$DB->query("SELECT count(*) from pay_user")->fetchColumn();
$data=unserialize(file_get_contents(SYSTEM_ROOT.'db.txt'));
$mysqlversion=$DB->query("select VERSION()")->fetch();
?>
  <div class="container" style="padding-top:70px;">
    <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
      <div class="panel panel-primary">
        <div class="panel-heading"><h3 class="panel-title">后台管理首页</h3></div>
          <ul class="list-group">
            <li class="list-group-item"><span class="glyphicon glyphicon-stats"></span> <b>订单总数：</b><?php echo $count1?> 条</li>
			<li class="list-group-item"><span class="glyphicon glyphicon-tint"></span> <b>商户数量：</b><?php echo $count2?> 个</li>
			<li class="list-group-item"><span class="glyphicon glyphicon-tint"></span> <b>总计余额：</b><?php echo $data['usermoney']?> 元</li>
			<li class="list-group-item"><span class="glyphicon glyphicon-tint"></span> <b>结算余额：</b><?php echo $data['settlemoney']?> 元</li>
            <li class="list-group-item"><span class="glyphicon glyphicon-time"></span> <b>现在时间：</b> <?=$date?></li>
            <li class="list-group-item"><span class="glyphicon glyphicon-flag"></span> <b>余额提醒：</b> 若长时间余额没有刷新，请重新设置监控 你的域名/cron.php</li>
            <li class="list-group-item"><span class="glyphicon glyphicon-flag"></span> <b>余额提醒：</b> 若长时间列表没有刷新，请重新设置监控 你的域名/cron.php?do=settle</li>
			<li class="list-group-item"><span class="glyphicon glyphicon-home"></span> <a href="../" class="btn btn-xs btn-primary">返回首页</a>&nbsp;&nbsp;
              <a href="../cron.php" class="btn btn-xs btn-primary" target="_blank">手动刷新余额</a>&nbsp;&nbsp;
              <a href="../cron.php?do=settle" class="btn btn-xs btn-primary" target="_blank">手动刷新结算列表</a>&nbsp;&nbsp;
              <a href="./settle.php" class="btn btn-xs btn-primary" target="_blank">结算操作</a>&nbsp;&nbsp;
              <a href="./slist.php" class="btn btn-xs btn-primary" target="_blank">结算记录</a>&nbsp;&nbsp;
			</li>
          </ul>
      </div>
	  <div class="panel panel-success">
          <table class="table table-bordered table-striped">
		    <thead><tr><th class="success">订单收入统计</th><th>支付宝</th><th>微信支付</th><th>QQ钱包</th><th>财付通</th><th>总计</th></thead>
            <tbody>
			  <tr><td>今日</td><td><?php echo round($data['order_today']['alipay'],2)?></td><td><?php echo round($data['order_today']['wxpay'],2)?></td><td><?php echo round($data['order_today']['qqpay'],2)?></td><td><?php echo round($data['order_today']['tenpay'],2)?></td><td><?php echo round($data['order_today']['all'],2)?></td></tr>
			  <tr><td>昨日</td><td><?php echo round($data['order_lastday']['alipay'],2)?></td><td><?php echo round($data['order_lastday']['wxpay'],2)?></td><td><?php echo round($data['order_lastday']['qqpay'],2)?></td><td><?php echo round($data['order_lastday']['tenpay'],2)?></td><td><?php echo round($data['order_lastday']['all'],2)?></td></tr>
			</tbody>
          </table>
      </div>
<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title">服务器信息</h3>
	</div>
	<ul class="list-group">
		<li class="list-group-item">
			<b>PHP 版本：</b><?php echo phpversion() ?>
			<?php if(ini_get('safe_mode')) { echo '线程安全'; } else { echo '非线程安全'; } ?>
		</li>
		<li class="list-group-item">
			<b>MySQL 版本：</b><?php echo $mysqlversion[0] ?>
		</li>
		<li class="list-group-item">
			<b>服务器软件：</b><?php echo $_SERVER['SERVER_SOFTWARE'] ?>
		</li>
		
		<li class="list-group-item">
			<b>程序最大运行时间：</b><?php echo ini_get('max_execution_time') ?>s
		</li>
		<li class="list-group-item">
			<b>POST许可：</b><?php echo ini_get('post_max_size'); ?>
		</li>
		<li class="list-group-item">
			<b>文件上传许可：</b><?php echo ini_get('upload_max_filesize'); ?>
		</li>
	</ul>
</div>
    </div>
  </div>