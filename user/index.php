<?php
include("../includes/common.php");
if($islogin2==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$title='用户中心';
include './head.php';
?>
<?php
$gg=$DB->query("SELECT * from gg")->fetchColumn();
$orders=$DB->query("SELECT count(*) from pay_order WHERE pid={$pid}")->fetchColumn();
$lastday=date("Y-m-d",strtotime("-1 day")).' 00:00:00';
$today=date("Y-m-d").' 00:00:00';
$order_today=$DB->query("SELECT sum(money) from pay_order where pid={$pid} and status=1 and endtime>='$today'")->fetchColumn();
$order_lastday=$DB->query("SELECT sum(money) from pay_order where pid={$pid} and status=1 and endtime>='$lastday' and endtime<'$today'")->fetchColumn();
$rs=$DB->query("SELECT * from pay_settle where pid={$pid} and status=1");
$settle_money=0;
$max_settle=0;
$chart='';
$i=0;
while($row = $rs->fetch())
{
	$settle_money+=$row['money'];
	if($row['money']>$max_settle)$max_settle=$row['money'];
	if($i<9)$chart.='['.$i.','.$row['money'].'],';
	$i++;
}
$chart=substr($chart,0,-1);

if($conf['verifytype']==1 && empty($userrow['phone']))$alertinfo='你还没有绑定密保手机，请&nbsp;<a href="userinfo.php" class="btn btn-sm btn-info">尽快绑定</a>';
elseif(empty($userrow['email']))$alertinfo='你还没有绑定密保邮箱，请&nbsp;&nbsp;<a href="userinfo.php" class="btn btn-sm btn-info">尽快绑定</a>';
elseif($userrow['shiming']==0)$alertinfo='你还没有进行实名认证，请尽快&nbsp;&nbsp;<a href="yanzheng.php" class="btn btn-sm btn-info">实名认证</a>';
?>
 <div id="content" class="app-content" role="main">
    <div class="app-content-body ">
		<div class="modal inmodal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span>
						</button>
						<h4 class="modal-title">提示信息</h4>
					</div>
					<div class="modal-body">
<?php echo $alertinfo?>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
					</div>
				</div>
			</div>
		</div>

<div class="bg-light lter b-b wrapper-md hidden-print">
  <h1 class="m-n font-thin h3">用户中心</h1>
  <small class="text-muted">欢迎使用<?php echo $conf['web_name']?></small>
</div>
<div class="wrapper-md control">
<!-- stats -->
      <div class="row">
        <div class="col-md-5">
          <div class="row row-sm text-center">
            <div class="col-xs-6">
              <div class="panel padder-v item">
                <div class="h1 text-info font-thin h1"><?php echo $orders?>个</div>
                <span class="text-muted text-xs">订单总数</span>
                <div class="top text-right w-full">
                  <i class="fa fa-caret-down text-warning m-r-sm"></i>
                </div>
              </div>
            </div>
            <div class="col-xs-6">
              <div class="block panel padder-v bg-primary item">
                <span class="text-white font-thin h1 block">￥<?php echo $settle_money?></span>
                <span class="text-muted text-xs">已结算余额</span>
                <span class="bottom text-right w-full">
                  <i class="fa fa-caret-down text-muted m-r-sm"></i>
                </span>
              </div>
            </div>
            <div class="col-xs-6">
              <div class="block panel padder-v bg-info item">
                <span class="text-white font-thin h1 block">￥<?php echo $order_today?></span>
                <span class="text-muted text-xs">今日收入</span>
                <span class="top">
                  <i class="fa fa-caret-up text-warning m-l-sm m-r-sm"></i>
                </span>
              </div>
            </div>
            <div class="col-xs-6">
              <div class="panel padder-v item">
                <div class="font-thin h1">￥<?php echo $order_lastday?></div>
                <span class="text-muted text-xs">昨日收入</span>
                <div class="bottom">
                  <i class="fa fa-caret-up text-warning m-l-sm m-r-sm"></i>
                </div>
              </div>
            </div>
            <div class="col-xs-12 m-b-md">
              <div class="r bg-light dker item hbox no-border">
                <div class="col w-xs v-middle hidden-md">
                  <div ng-init="d3_3=[60,40]" ui-jq="sparkline" ui-options="[60,40], {type:'pie', height:40, sliceColors:['#fad733','#fff']}" class="sparkline inline"></div>
                </div>
                <div class="col dk padder-v r-r">
                  <div class="text-primary-dk font-thin h1"><span>￥<?php echo $userrow['money']?></span></div>
                  <span class="text-muted text-xs">商户当前余额</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-7">
          <div class="panel wrapper">
            <label class="i-switch bg-warning pull-right" ng-init="showSpline=true">
              <input type="checkbox" ng-model="showSpline">
              <i></i>
            </label>
            <h4 class="font-thin m-t-none m-b text-muted">结算统计表</h4>
            <div ui-jq="plot" ui-refresh="showSpline" ui-options="
              [
                { data: [ <?php echo $chart?> ], label:'结算金额', points: { show: true, radius: 1}, splines: { show: true, tension: 0.4, lineWidth: 1, fill: 0.8 } }
              ], 
              {
                colors: ['#23b7e5', '#7266ba'],
                series: { shadowSize: 3 },
                xaxis:{ font: { color: '#a1a7ac' } },
                yaxis:{ font: { color: '#a1a7ac' }, max:<?php echo ($max_settle+10)?> },
                grid: { hoverable: true, clickable: true, borderWidth: 0, color: '#dce5ec' },
                tooltip: true,
                tooltipOpts: { content: '结算金额￥%y',  defaultTheme: false, shifts: { x: 10, y: -25 } }
              }
            " style="height:246px" >
            </div>
          </div>
        </div>
      </div>
      <!-- / stats -->
	<div class="panel panel-default">
		<div class="panel-heading font-bold">
			基本资料
		</div>
		<div class="panel-body">
			<form class="form-horizontal devform">
				<div class="form-group">
					<label class="col-sm-2 control-label">商户ID</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" value="<?php echo $pid?>" disabled>
					</div>
				</div>
				<div class="line line-dashed b-b line-lg pull-in"></div>
				<div class="form-group">
					<label class="col-sm-2 control-label">商户密钥</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" value="<?php echo $userrow['key']?>" disabled>
					</div>
				</div>
				<div class="line line-dashed b-b line-lg pull-in"></div>
				<div class="form-group">
					<label class="col-sm-2 control-label">账号绑定</label>
					<div class="col-sm-9">
					<?php if(empty($userrow['alipay_uid'])){?>
						<a href="oauth.php?bind=true" class="btn btn-primary btn-sm" target="_blank">绑定支付宝账号 一键登录到本站</a>
					<?php }else{?>
						已绑定支付宝UID:<?php echo $userrow['alipay_uid']?>&nbsp;<a href="oauth.php?unbind=true" class="btn btn-danger btn-xs" onclick="return confirm('解绑后将无法通过支付宝一键登录，是否确定解绑？');">解绑账号</a>
					<?php }?>
					<!--<?php if(empty($userrow['qq_uid'])){?>
						<a href="connect.php?bind=true" class="btn btn-primary btn-sm" target="_blank">绑定QQ 一键登录到本站</a>
					<?php }else{?>
						已绑定QQ互联Openid:<?php echo $userrow['qq_uid']?>&nbsp;<a href="connect.php?unbind=true" class="btn btn-danger btn-xs" onclick="return confirm('解绑后将无法通过支付宝一键登录，是否确定解绑？');">解绑账号</a>
					<?php }?>-->
					</div>
				</div>
			</form>
		</div>
	</div>
  <!--商户公告页-->
  <div class="panel panel-default">
		<div class="panel-heading font-bold">商户公告</div>
  <div class="panel-body">
    <?php echo $gg ?>
    </div>
   <!--End-->
</div>
    </div>
  </div>



<?php include 'foot.php';?>
<script>
$(document).ready(function(){
	<?php if(isset($alertinfo)){?>$('#myModal').modal('show');<?php }?>
});
</script>