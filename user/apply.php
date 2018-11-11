<?php
include("../includes/common.php");
if($islogin2==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$title='我的钱包';
include './head.php';
?>
<?php

if($conf['settle_open']==0)exit('未开启申请提现');

$today=date("Y-m-d").' 00:00:00';
$rs=$DB->query("SELECT * from pay_order where pid={$pid} and status=1 and endtime>='$today'");
$order_today=0;
while($row = $rs->fetch())
{
	$order_today+=$row['money'];
}
$enable_money=round($userrow['money']-$order_today*$conf['money_rate']/100,2);

if(isset($_GET['act']) && $_GET['act']=='do'){
	if($_POST['submit']=='申请提现'){
		if($userrow['apply']==1){
			exit("<script language='javascript'>alert('你今天已经申请过提现，请勿重复申请！');history.go(-1);</script>");
		}
		if($enable_money<$conf['settle_money']){
			exit("<script language='javascript'>alert('可提现余额不足！');history.go(-1);</script>");
		}
		if($userrow['type']==2){
			exit("<script language='javascript'>alert('您的商户出现异常，无法提现');history.go(-1);</script>");
		}
		$sqs=$DB->exec("update `pay_user` set `apply` ='1' where `id`='$pid'");
		exit("<script language='javascript'>alert('申请提现成功！');history.go(-1);</script>");
	}
}


?>
 <div id="content" class="app-content" role="main">
    <div class="app-content-body ">

<div class="bg-light lter b-b wrapper-md hidden-print">
  <h1 class="m-n font-thin h3">我的钱包</h1>
</div>
<div class="wrapper-md control">
<?php if(isset($msg)){?>
<div class="alert alert-info">
	<?php echo $msg?>
</div>
<?php }?>
	<div class="panel panel-default">
		<div class="panel-heading font-bold">
			我的钱包
		</div>
		<div class="panel-body">
			<form class="form-horizontal devform" action="./apply.php?act=do" method="post">
				<div class="form-group">
					<label class="col-sm-2 control-label">支付宝账号</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" value="<?php echo $userrow['account']?>" disabled>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">支付宝姓名</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" value="<?php echo $userrow['username']?>" disabled>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">当前余额</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" value="<?php echo $userrow['money']?>" disabled>
					</div>
				</div>
              <!--新版无用，可以去掉
				<div class="form-group">
					<label class="col-sm-2 control-label">可提现余额</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="tmoney" value="<?php echo $enable_money?>" disabled>
					</div>
				</div>
				<div class="form-group">
				  <div class="col-sm-offset-2 col-sm-4"><input type="submit" name="submit" value="申请提现" class="btn btn-primary form-control"/><br/>
				 </div>-->
				<div class="line line-dashed b-b line-lg pull-in"></div>
				<div class="form-group">
					<label class="col-sm-2"></label>
					<div class="col-sm-6">
					<h4><span class="glyphicon glyphicon-info-sign"></span>注意事项</h4>
						当前最低提现金额为<b><?php echo $conf['settle_money']?></b>元<br/>
						本站提现模式为：自动提现 ；当您的余额满足提现的要求时次日自动提现。<br>
                      	目前解散日期为T+1，若要修改为T+0请联系客服修改<br>                     
                      	当前余额不等于可提现余额，具体金额以客服审核后入账为准。<br><br>
                      	问题解答：<br>
                      	Q：我余额有5元，为什么到账只有4.85元？<br>
                      	A：本站费率1%，提现先扣最低手续费。扣除的手续费将在每次提现后的7个工作日内返回到您的账户内。
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
    </div>
  </div>

<?php include 'foot.php';?>