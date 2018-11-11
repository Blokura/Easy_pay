<?php
include("../includes/common.php");
if($islogin2==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$title='实名认证';
include './head.php';
?>

 <div id="content" class="app-content" role="main">
    <div class="app-content-body ">

<div class="bg-light lter b-b wrapper-md hidden-print">
  <h1 class="m-n font-thin h3">实名认证</h1>
</div>
<div class="wrapper-md control">
<?php if(isset($msg)){?>
<div class="alert alert-info">
	<?php echo $msg?>
</div>
<?php }?>
	<div class="panel panel-default">
		<div class="panel-heading font-bold">
			实名认证
		</div>
		<div class="panel-body">
			<form class="form-horizontal devform" action="" method="post">
				<div class="form-group">
					<label class="col-sm-2 control-label">姓名</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" value="" placeholder="请输入您本人的姓名">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">身份证号码</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" value="" placeholder="请输入您本人的身份证号码">
					</div>
				</div>

				<div class="form-group">
				  <div class="col-sm-offset-2 col-sm-4"><input type="submit" name="submit" value="开始认证" class="btn btn-primary form-control"/><br/><br/>
				 </div>
				<div class="line line-dashed b-b line-lg pull-in"></div>
				<div class="form-group">
					<label class="col-sm-2"></label>
					<div class="col-sm-6">
					<h4><span class="glyphicon glyphicon-info-sign"></span>注意事项</h4>
                      <b>未实名用户最高提现500元</b><br/>
						网站会保留您的个人姓名以及身份证号码，您可以通过注销账号或联系客服来注销身份信息<br>
                      	注销身份信息后信息将不作保留，并且最高提现500元，若已经超过500元则无法提现<br>                     
                      <b>实名接口使用支付宝官方接口，本站无权获取您的其他信息，请放心</b><br>
                      	<b>请使用在本站填的信息的支付宝进行认证，否则将认证失败</b><br>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
    </div>
  </div>

<?php include 'foot.php';?>