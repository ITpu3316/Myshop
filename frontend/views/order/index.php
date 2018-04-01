<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>填写核对订单信息</title>
	<link rel="stylesheet" href="/style/base.css" type="text/css">
	<link rel="stylesheet" href="/style/global.css" type="text/css">
	<link rel="stylesheet" href="/style/header.css" type="text/css">
	<link rel="stylesheet" href="/style/fillin.css" type="text/css">
	<link rel="stylesheet" href="/style/footer.css" type="text/css">

	<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="/js/cart2.js"></script>

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
			<div class="flow fr flow2">
				<ul>
					<li>1.我的购物车</li>
					<li class="cur">2.填写核对订单信息</li>
					<li>3.成功提交订单</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- 页面头部 end -->
	
	<div style="clear:both;"></div>
<form>
    <input type="hidden" name="_csrf-frontend" value="<?=Yii::$app->request->csrfToken?>"/>
	<!-- 主体部分 start -->
	<div class="fillin w990 bc mt15">
		<div class="fillin_hd">
			<h2>填写并核对订单信息</h2>
		</div>

		<div class="fillin_bd">
			<!-- 收货人信息  start-->
			<div class="address">
				<h3>收货人信息</h3>
				<div class="address_info">
                    <?php foreach ($addresss as $address):?>
				<p>
					<input type="radio" value="<?=$address->id?>" name="address_id" <?=$address->status==1?"checked":""?>/><?=$address->name?> <?=$address->province?> <?=$address->city?> <?=$address->county?> <?=$address->address?> <?=$address->mobile?> </p>
                    <?php endforeach;?>
				</div>


			</div>
			<!-- 收货人信息  end-->

			<!-- 配送方式 start -->
			<div class="delivery">
				<h3>送货方式</h3>
				<div class="delivery_select">
					<table>
                        <?php foreach ($deliverys as $key=>$vel):?>
						<tbody>

							<tr class="<?=$key?"":"cur"?>">
								<td>
									<input type="radio" value="<?=$vel->id?>" name="delivery" <?=$key==0?"checked":""?> /><?=$vel['delivery_name']?>
								</td>
								<td>￥<span><?=$vel->delivery_price?></span></td>
								<td>每张订单不满499.00元,运费15.00元, 订单4...</td>
							</tr>

						</tbody>
                        <?php endforeach;?>
					</table>
					<a href="" class="confirm_btn"><span>确认送货方式</span></a>
				</div>
			</div> 
			<!-- 配送方式 end --> 

			<!-- 支付方式  start-->
			<div class="pay">
				<h3>支付方式</h3>
				<div class="pay_select">
					<table>
                        <?php foreach ($pays as $ke=>$ve):?>
						<tr class="<?=$ke?"":"cur"?>">
							<td class="col1">
                                <input type="radio" value="<?=$ve
                                ->id?>" name="pay" <?=$ke==0?"checked":""?>/><?=$ve->pay_type?>
                            </td>
							<td class="col2"><?=$ve->pay_detail?></td>
						</tr>
                        <?php endforeach;?>
					</table>
					<a href="" class="confirm_btn"><span>确认支付方式</span></a>
				</div>
			</div>
			<!-- 支付方式  end-->

			<!-- 发票信息 start-->

			<!-- 发票信息 end-->

			<!-- 商品清单 start -->
			<div class="goods">
				<h3>商品清单</h3>
				<table>
					<thead>
						<tr>
							<th class="col1">商品</th>
							<th class="col3">价格</th>
							<th class="col4">数量</th>
							<th class="col5">小计</th>
						</tr>	
					</thead>
					<tbody>
                    <?php foreach ($goods as $gds):?>
						<tr>
							<td class="col1"><a href=""><img src="<?=$gds->logo?>" alt="" /></a>  <strong><a href=""><?=$gds->name?></a></strong></td>
							<td class="col3">￥<?=$gds->shop_price?></td>
							<td class="col4"> <?=$cart[$gds->id]?></td>
							<td class="col5"><span>￥<?=number_format($gds->shop_price*$cart[$gds->id],2)?></span></td>
						</tr>
                    <?php endforeach;?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="5">
								<ul>
									<li>
										<span><?=$shopNum?> 件商品，总商品金额：</span>
										<em>￥<span id="goods_price"><?=$shopPrice?></span></em>
									</li>
									<li>
										<span>运费：</span>
										<em>￥<span id="price"><?=$vel->delivery_price?></span></em>
									</li>
									<li>
										<span>应付总额：</span>
										<em>￥<span class="all_price"><?=number_format($shopPrice+$vel->delivery_price,2)?></span></em>
									</li>
								</ul>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
			<!-- 商品清单 end -->
		
		</div>

		<div class="fillin_ft">
			<a href="javascript:;" id="sub_btn"><span>提交订单</span></a>
			<p>应付总额：<strong>￥<span class="all_price"><?=number_format($shopPrice+$vel->delivery_price,2)?>元</strong></span></p>
			
		</div>
	</div>
	<!-- 主体部分 end -->
</form>
	<div style="clear:both;"></div>
	<!-- 底部版权 start -->
    <?=\frontend\widgets\FooterWidgets::widget()?>
	<!-- 底部版权 end -->
    <script type="text/javascript" src="/layer/layer.js"></script>
<script>
    $(function () {
        //监听配送方式
        $("input[name='delivery']").change(function () {
        //得到当前的运费
            var price=$(this).parent().next().children().text();
        console.log(price);
        //更改运费
            $("#price").text(price);
            //更改总价
            $(".all_price").text((parseFloat(price)+parseFloat($("#goods_price").text())).toFixed(2))
//            console.log(price);
        });
        //提交订单
        $("#sub_btn").click(function () {
//            console.log(111111);
            //提交数据
            $.post('/order/add',$("form").serialize(),function (data) {
                console.dir(data.status);
                //判断数据
                if (data.status){
                    //提示信息
                    layer.msg(data.msg);
//                  alert(data.msg);
                    //跳转到订单完成界面
                    self.location.href="/order/add";
                }else {
                    $.each(data.data,function (k,v) {
                        layer.tips(v[0], '#'+k, {
                            tips: [2, '#0FA6D8'], //还可配置颜色
                            tipsMore: true,
                        });
                    });
                }
            },'json');
        })
    });
</script>
</body>
</html>
