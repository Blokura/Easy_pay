<?php
@header('Content-Type: text/html; charset=UTF-8');
if($userrow['active']==0){
	sysmsg('由于你的商户违反相关法律法规与《'.$conf['web_name'].'用户协议》，已被禁用！');
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8" />
  <title><?php echo $title?> | <?php echo $conf['web_name']?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <link rel="stylesheet" href="https://template.down.swap.wang/ui/angulr_2.0.1/bower_components/bootstrap/dist/css/bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="https://cdn.css.net/libs/animate.css/3.5.1/animate.css" type="text/css" />
  <link rel="stylesheet" href="https://cdn.css.net/libs/font-awesome/4.5.0/css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="https://cdn.css.net/libs/simple-line-icons/2.2.4/css/simple-line-icons.css" type="text/css" />
  <link rel="stylesheet" href="https://template.down.swap.wang/ui/angulr_2.0.1/html/css/font.css" type="text/css" />
  <link rel="stylesheet" href="https://template.down.swap.wang/ui/angulr_2.0.1/html/css/app.css" type="text/css" />
  <link rel="stylesheet" href="https://admin.down.swap.wang/assets/plugins/toastr/toastr.min.css" type="text/css" />

</head>
<body>
<div class="app app-header-fixed  ">
  <!-- header -->
  <header id="header" class="app-header navbar" role="menu">
          <!-- navbar header -->
      <div class="navbar-header bg-dark">
        <button class="pull-right visible-xs dk" ui-toggle="show" target=".navbar-collapse">
          <i class="glyphicon glyphicon-cog"></i>
        </button>
        <button class="pull-right visible-xs" ui-toggle="off-screen" target=".app-aside" ui-scroll="app">
          <i class="glyphicon glyphicon-align-justify"></i>
        </button>
        <!-- brand -->
        <a href="/" class="navbar-brand text-lt">
          <i class="fa fa-btc"></i>
          <img src="https://template.down.swap.wang/ui/angulr_2.0.1/html/img/logo.png" alt="." class="hide">
          <span class="hidden-folded m-l-xs"><?php echo $conf['web_name']?></span>
        </a>
        <!-- / brand -->
      </div>
      <!-- / navbar header -->

      <!-- navbar collapse -->
      <div class="collapse pos-rlt navbar-collapse box-shadow bg-white-only">
        <!-- buttons -->
        <div class="nav navbar-nav hidden-xs">
          <a href="#" class="btn no-shadow navbar-btn" ui-toggle="app-aside-folded" target=".app">
            <i class="fa fa-dedent fa-fw text"></i>
            <i class="fa fa-indent fa-fw text-active"></i>
          </a>
        </div>
        <!-- / buttons -->

        <!-- nabar right -->
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="dropdown-toggle clear" data-toggle="dropdown">
              <span class="thumb-sm avatar pull-right m-t-n-sm m-b-n-sm m-l-sm">
                <img src="<?php echo ($userrow['qq'])?'//q2.qlogo.cn/headimg_dl?bs=qq&dst_uin='.$userrow['qq'].'&src_uin='.$userrow['qq'].'&fid='.$userrow['qq'].'&spec=100&url_enc=0&referer=bu_interface&term_type=PC':'assets/img/user.png'?>">
                <i class="on md b-white bottom"></i>
              </span>
              <span class="hidden-sm hidden-md" style="text-transform:uppercase;"><?php echo $pid?></span> <b class="caret"></b>
            </a>
            <!-- dropdown -->
            <ul class="dropdown-menu animated fadeInRight w">
              <li>
                <a href="index.php">
                  <span>用户中心</span>
                </a>
              </li>
              <li>
                <a href="userinfo.php">
                  <span>修改资料</span>
                </a>
              </li>
              <li class="divider"></li>
              <li>
                <a ui-sref="access.signin" href="login.php?logout">退出登录</a>
              </li>
            </ul>
            <!-- / dropdown -->
          </li>
        </ul>
        <!-- / navbar right -->
      </div>
      <!-- / navbar collapse -->
  </header>
  <!-- / header -->
  <!-- aside -->
  <aside id="aside" class="app-aside hidden-xs bg-dark">
      <div class="aside-wrap">
        <div class="navi-wrap">

          <!-- nav -->
          <nav ui-nav class="navi clearfix">
            <ul class="nav">
              <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                <span>导航</span>
              </li>
              <li>
                <a href="./">
                  <i class="glyphicon glyphicon-home icon text-primary-dker"></i>
				  
                  <span class="font-bold">用户中心</span>
                </a>
              </li>
              <li>
                <a href class="auto">      
                  <span class="pull-right text-muted">
                    <i class="fa fa-fw fa-angle-right text"></i>
                    <i class="fa fa-fw fa-angle-down text-active"></i>
                  </span>
                  <i class="glyphicon glyphicon-leaf icon text-success-lter"></i>
                  <span>账户安全</span>
                </a>
                <ul class="nav nav-sub dk">
                  <li class="nav-sub-header">
                    <a href>
                      <span>账户安全</span>
                    </a>
                  </li>
				  <li>
                    <a href="userinfo.php">
                      <span>修改资料</span>
                    </a>
                  </li>
                  <li>
                    <a href="yanzheng.php">
                      <span>实名认证</span>
                    </a>
                  </li>
                  <li>
                    <a href="verification.php" onclick="alert('暂未开放');return false;">
                      <span>验证信息</span>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="line dk"></li>
              <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                <span>查询</span>
              </li>
			  <li>
                <a href="order.php">
                  <i class="glyphicon glyphicon-list-alt"></i>
                  <span>订单记录</span>
                </a>
              </li>
			  <li>
                <a href="settle.php">
                  <i class="glyphicon glyphicon-th-list"></i>
                  <span>结算记录</span>
                </a>
              </li>
              <li>
                <a href="apply.php">
                  <i class="glyphicon glyphicon-upload"></i>
                  <span>我的钱包</span>
                </a>
              </li>
              <li class="line dk hidden-folded"></li>

              <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">          
                <span>帮助</span>
              </li>
              <li>
                <a href="help.php">
                  <i class="glyphicon glyphicon-info-sign"></i>
                  <span>结算时效</span>
                </a>
              </li>
              <li>
                <a href="http://sighttp.qq.com/authd?IDKEY=8417a296956fc8fb9106d7de880c14f0784f8ee4941f4baa" target="blank">
                  <i class="fa fa-qq"></i>
                  <span>联系客服</span>
                </a>
              </li>
            </ul>
          </nav>
          <!-- nav -->

          <!-- aside footer 
          <div class="wrapper m-t">
            <div class="text-center-folded">
              <span class="pull-right pull-none-folded">60%</span>
              <span class="hidden-folded">Milestone</span>
            </div>
            <div class="progress progress-xxs m-t-sm dk">
              <div class="progress-bar progress-bar-info" style="width: 60%;">
              </div>
            </div>
            <div class="text-center-folded">
              <span class="pull-right pull-none-folded">35%</span>
              <span class="hidden-folded">Release</span>
            </div>
            <div class="progress progress-xxs m-t-sm dk">
              <div class="progress-bar progress-bar-primary" style="width: 35%;">
              </div>
            </div>
          </div>
          <!-- / aside footer -->
        </div>
      </div>
  </aside>
  <!-- / aside -->
  <!-- content -->