<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>成功提交订单</title>
	<link rel="stylesheet" href="/style/base.css" type="text/css">
	<link rel="stylesheet" href="/style/global.css" type="text/css">
	<link rel="stylesheet" href="/style/header.css" type="text/css">
	<link rel="stylesheet" href="/style/success.css" type="text/css">
	<link rel="stylesheet" href="/style/footer.css" type="text/css">
    <meta http-equiv=refresh content=5;url='/index/index value="/biz/safemanage/enterpriseMain.jsp"/>
</head>
<body>
	<!-- 顶部导航 start -->
    <?php
    include Yii::getAlias('@app')."/views/common/nav.php";
    ?>
	<!-- 顶部导航 end -->
	
	<div style="clear:both;"></div>
	
	<!-- 页面头部 start -->
	<div class="header w990 bc mt15">
		<div class="logo w990">
			<h2 class="fl"><a href="index.html"><img src="/images/logo.png" alt="京西商城"></a></h2>
			<div class="flow fr flow3">
				<ul>
					<li>1.我的购物车</li>
					<li>2.填写核对订单信息</li>
					<li class="cur">3.成功提交订单</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- 页面头部 end -->
	
	<div style="clear:both;"></div>

	<!-- 主体部分 start -->
	<div class="success w990 bc mt15">
		<div class="success_hd">
			<h2>订单提交成功</h2>
		</div>
		<div class="success_bd">
			<p><span></span>订单提交成功，我们将及时为您处理</p>
            <font size=2><span id="jump">5</span>秒后自动跳转</font>
			<p class="message">完成支付后，你可以
                <a href="">查看订单状态</a>
                <a href="<?=\yii\helpers\Url::to('index/index')?>">继续购物</a>
                <a href="">问题反馈</a>
            </p>
		</div>
	</div>
    <script>
        function countDown(secs){
            jump.innerText=secs;
            if(--secs>0)
                setTimeout( "countDown(" +secs+ ")" ,1000);
        }
        countDown(5);
    </script>

    <!--    <meta http-equiv="refresh" content="3;URL=http://www.baidu.com">-->
    <!-- 主体部分 end -->

	<div style="clear:both;"></div>
	<!-- 底部版权 start -->
    <?=\frontend\widgets\FooterWidgets::widget()?>
	<!-- 底部版权 end -->
</body>
</html>
