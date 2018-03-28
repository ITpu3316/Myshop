<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>收货地址</title>
	<link rel="stylesheet" href="/style/base.css" type="text/css">
	<link rel="stylesheet" href="/style/global.css" type="text/css">
	<link rel="stylesheet" href="/style/header.css" type="text/css">
	<link rel="stylesheet" href="/style/home.css" type="text/css">
	<link rel="stylesheet" href="/style/address.css" type="text/css">
	<link rel="stylesheet" href="/style/bottomnav.css" type="text/css">
	<link rel="stylesheet" href="/style/footer.css" type="text/css">

	<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="/js/header.js"></script>
	<script type="text/javascript" src="/layer/layer.js"></script>
	<script type="text/javascript" src="/js/home.js"></script>
</head>
<body>
<!-- 顶部导航 start -->
<?php
include Yii::getAlias('@app')."/views/common/nav.php";
?>
<!-- 顶部导航 end -->

<div style="clear:both;"></div>

<!-- 头部 start -->
<?php
include Yii::getAlias('@app')."/views/common/header.php";
?>
<!-- 头部 end-->
	
	<div style="clear:both;"></div>

	<!-- 页面主体 start -->
	<div class="main w1210 bc mt10">
		<div class="crumb w1210">
			<h2><strong>我的XX </strong><span>> 我的订单</span></h2>
		</div>
		
		<!-- 左侧导航菜单 start -->
		<div class="menu fl">
			<h3>我的XX</h3>
			<div class="menu_wrap">
				<dl>
					<dt>订单中心 <b></b></dt>
					<dd><b>.</b><a href="">我的订单</a></dd>
					<dd><b>.</b><a href="">我的关注</a></dd>
					<dd><b>.</b><a href="">浏览历史</a></dd>
					<dd><b>.</b><a href="">我的团购</a></dd>
				</dl>

				<dl>
					<dt>账户中心 <b></b></dt>
					<dd class="cur"><b>.</b><a href="">账户信息</a></dd>
					<dd><b>.</b><a href="">账户余额</a></dd>
					<dd><b>.</b><a href="">消费记录</a></dd>
					<dd><b>.</b><a href="">我的积分</a></dd>
					<dd><b>.</b><a href="">收货地址</a></dd>
				</dl>

				<dl>
					<dt>订单中心 <b></b></dt>
					<dd><b>.</b><a href="">返修/退换货</a></dd>
					<dd><b>.</b><a href="">取消订单记录</a></dd>
					<dd><b>.</b><a href="">我的投诉</a></dd>
				</dl>
			</div>
		</div>
		<!-- 左侧导航菜单 end -->

		<!-- 右侧内容区域 start -->
		<div class="content fl ml10">
			<div class="address_hd">
				<h3>收货地址薄</h3>
                <?php foreach ($addre as $k1=>$v1):?>
				<dl class="<?=$k1==count($addre)-1?"last":""?>">
					<dt><?=$v1->name?> <?=$v1->province?> <?=$v1->city?> <?=$v1->county?> <?=$v1->address?> <?=$v1->mobile?> </dt>
					<dd>
						<a href="">修改</a>
						<a href="javascript:void(0)" class="del" data-id="<?=$v1->id?>">删除</a>
						<a href="<?=\yii\helpers\Url::to(['default','id'=>$v1->id])?>" class="default"><?php
                            if ($v1->status===1){
                                echo "取消默认地址";
                            }else{
                                echo "设置默认地址";
                            }
                            ?></a>
					</dd>
				</dl>
				<?php endforeach;?>

			</div>

			<div class="address_bd mt10">
				<h4>新增收货地址</h4>
				<form action="" name="address_form" id="address_form">
                    <input type="hidden" name="_csrf-frontend" value="<?=Yii::$app->request->csrfToken?>"/>
						<ul>
							<li>
								<label for=""><span>*</span>收 货 人：</label>
								<input type="text" name="Address[name]" class="txt" id="name"/>
							</li>
							<li>
								<label for=""><span>*</span>所在地区：</label>
                                <!--省-->
                                <select name="Address[province]" id="province"></select>
                                <!--市-->
                                <select name="Address[city]" id="city"></select>
                                <!--区县-->
                                <select name="Address[county]" id="county"></select>
							</li>
							<li>
								<label for=""><span>*</span>详细地址：</label>
								<input type="text" name="Address[address]" class="txt address" id="address"/>
							</li>
							<li>
								<label for=""><span>*</span>手机号码：</label>
								<input type="text" name="Address[mobile]" class="txt" id="mobile"/>
							</li>
							<li>
								<label for="">&nbsp;</label>
								<input type="checkbox" name="Address[status]" class="check" />设为默认地址
							</li>
							<li>
								<label for="">&nbsp;</label>
								<input type="button" name="" class="btn" value="保存" />
							</li>
						</ul>
					</form>
			</div>	

		</div>
		<!-- 右侧内容区域 end -->
	</div>
	<!-- 页面主体 end-->

	<div style="clear:both;"></div>

	<!-- 底部导航 start -->
	<div class="bottomnav w1210 bc mt10">
		<div class="bnav1">
			<h3><b></b> <em>购物指南</em></h3>
			<ul>
				<li><a href="">购物流程</a></li>
				<li><a href="">会员介绍</a></li>
				<li><a href="">团购/机票/充值/点卡</a></li>
				<li><a href="">常见问题</a></li>
				<li><a href="">大家电</a></li>
				<li><a href="">联系客服</a></li>
			</ul>
		</div>
		
		<div class="bnav2">
			<h3><b></b> <em>配送方式</em></h3>
			<ul>
				<li><a href="">上门自提</a></li>
				<li><a href="">快速运输</a></li>
				<li><a href="">特快专递（EMS）</a></li>
				<li><a href="">如何送礼</a></li>
				<li><a href="">海外购物</a></li>
			</ul>
		</div>

		
		<div class="bnav3">
			<h3><b></b> <em>支付方式</em></h3>
			<ul>
				<li><a href="">货到付款</a></li>
				<li><a href="">在线支付</a></li>
				<li><a href="">分期付款</a></li>
				<li><a href="">邮局汇款</a></li>
				<li><a href="">公司转账</a></li>
			</ul>
		</div>

		<div class="bnav4">
			<h3><b></b> <em>售后服务</em></h3>
			<ul>
				<li><a href="">退换货政策</a></li>
				<li><a href="">退换货流程</a></li>
				<li><a href="">价格保护</a></li>
				<li><a href="">退款说明</a></li>
				<li><a href="">返修/退换货</a></li>
				<li><a href="">退款申请</a></li>
			</ul>
		</div>

		<div class="bnav5">
			<h3><b></b> <em>特色服务</em></h3>
			<ul>
				<li><a href="">夺宝岛</a></li>
				<li><a href="">DIY装机</a></li>
				<li><a href="">延保服务</a></li>
				<li><a href="">家电下乡</a></li>
				<li><a href="">京东礼品卡</a></li>
				<li><a href="">能效补贴</a></li>
			</ul>
		</div>
	</div>
	<!-- 底部导航 end -->
	<div style="clear:both;"></div>
<!-- 底部版权 start -->
<?=\frontend\widgets\FooterWidgets::widget()?>
<!-- 底部版权 end -->
<script language="javascript" src="/js/PCASClass.js"></script>
<script>
    new PCAS("Address[province]","Address[city]","Address[county]");
    //通过ajax请求数据提交
    $(function () {
        //监听点击添加事件
        $(".btn").click(function () {
            //提交数据提交
            $.post("/address/add",$("#address_form").serialize(),function (result) {
                console.log(result.status);
                //判断数据
                if (result.status==1){
                    //提示信息
                    layer.msg(result.msg);
                    //跳转到收货地址界面
                    window.location.href="/address/index";
                }else {

                    $.each(result.data,function (k,v) {
                        layer.tips(v[0], '#'+k, {
                            tips: [2, '#0FA6D8'], //还可配置颜色
                            tipsMore: true,
                        });
//                            alert(v[0]);
                        console.log(v[0]);
                    });

                }
            },'json');
        });
        //监听点击删除事件
        $(".del").click(function () {
            var del=$(this);//找到对象的本身
            var id=$(this).attr('data-id');
            $.getJSON('/address/del?id='+id,function (data) {
//               console.log(this);
               if (data.status){
                   //提示信息
                   layer.msg(data.msg);
                   //删除之前把数据删除
                   del.parent().parent().remove();
               }
            });

        });
        //监听点击设置默认地址事件
        $(".default").click(function () {

        });
    });
</script>

</body>
</html>

