<!DOCTYPE html>
<html lang="zh_CN">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<script type="text/javascript" src="//cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
	<title>跳转提示</title>
	<style type="text/css">
	*{margin:0; padding:0;}
	a{text-decoration: none;}
	img{max-width: 100%; height: auto;}
	.weixin-tip{display: none; position: fixed; left:0; top:0; bottom:0; background: rgba(0,0,0,0.8); filter:alpha(opacity=80);  height: 100%; width: 100%; z-index: 100;}
	.weixin-tip p{text-align: center; margin-top: 10%; padding:0 5%;}
	</style>
</head>
<body>
	<div class="weixin-tip">
		<p>
			<img src="live_weixin.png" alt="微信打开"/>
		</p>
	</div>
	<script type="text/javascript">
        $(window).on("load",function(){
			if(navigator.userAgent.indexOf("MicroMessenger")>0){
				var winHeight = $(window).height();
				$(".weixin-tip").css("height",winHeight);
				$(".weixin-tip").show();
			}
		})
	</script>
</body>
</html>