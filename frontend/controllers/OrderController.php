<?php

namespace frontend\controllers;

use backend\models\Delivery;
use backend\models\Goods;
use backend\models\Order;
use backend\models\OrderDetail;
use frontend\models\Address;
use frontend\models\GoodsCart;
use frontend\models\PayType;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Request;
use EasyWeChat\Foundation\Application;
use Endroid\QrCode\QrCode;

class OrderController extends \yii\web\Controller
{
    /**
     * 订单列表
     * @return string
     */
    public function actionIndex()
    {
        //判断有没有登录
        if (\Yii::$app->user->isGuest){
            return $this->redirect(['user/login','url'=>'/order/index']);
        }
        //查出收货地址
        $addresss=Address::find()->where(['user_id'=>\Yii::$app->user->id])->all();
        //查出配送方式
        $deliverys=\backend\models\Delivery::find()->all();
//        var_dump(array_keys($deliverys));exit();
        //查出支付方式
        $pays=\backend\models\PayType::find()->all();
//        var_dump($address['name']);exit();
        //取出商品
        $cart=GoodsCart::find()->where(['user_id'=>\Yii::$app->user->id])->asArray()->all();
        //把二维数组提取成一维数组
        $cart=ArrayHelper::map($cart,'goods_id','goods_num');//[5=>3,1=>1]
        //var_dump($cart);exit;
        //取出$cart中的所有key值
        $goodIds = array_keys($cart);
        //取购物车的所有商品
        $goods = Goods::find()->where(['in', 'id', $goodIds])->all();
        //商品总价
        $shopPrice=0;
        //商品总数
        $shopNum=0;
        foreach ($goods as $good){
            //算商品总价
            $shopPrice+=$good->shop_price*$cart[$good->id];
            $shopNum+=$cart[$good->id];
        }
        //二位小数
        $shopPrice=number_format($shopPrice,2);
        return $this->render('index',compact('addresss','deliverys','pays','cart','goods','shopPrice','shopNum'));
    }

    /**
     * 订单生成
     * @return string
     */
    public function actionAdd(){
        //用户ID
        $user_id=\Yii::$app->user->id;
        //判断post提交
        $request=new Request();
        if ($request->isPost) {
            $db = \Yii::$app->db;
            $transaction = $db->beginTransaction();//开启事务

            try {
//实例化order
                $order=new Order();
                //取出地址参数
                $addressId=$request->post('address_id');
//            var_dump($addressId);exit();
                $address=Address::findOne(['id'=>$addressId,'user_id'=>$user_id]);
                //取出配送方式数据
                $deliveryId=$request->post('delivery');
                $delivery=Delivery::findOne($deliveryId);
                //取出支付方式数据
                $payID=$request->post('pay');
                $pay=\backend\models\PayType::findOne($payID);

                //给订单数据orderr赋值
                $order->user_id=$user_id;//用户ID
                $order->name=$address->name;
                $order->procince=$address->province;
                $order->city=$address->city;
                $order->county=$address->county;
                $order->address=$address->address;
                $order->mobile=$address->mobile;

                $order->delivery_id=$delivery->id;//配送ID
                $order->delivery_name=$delivery->delivery_name;//配送名称
                $order->delivery_price=$delivery->delivery_price;//运费

                $order->pay_type_id=$pay->id;//支付ID
                $order->pay_type_name=$pay->pay_type;//支付名称

                //订单价格
                //取出商品
                $cart=GoodsCart::find()->where(['user_id'=>\Yii::$app->user->id])->asArray()->all();
                //把二维数组提取成一维数组
                $cart=ArrayHelper::map($cart,'goods_id','goods_num');//[5=>3,1=>1]
                //取出$cart中的所有key值
                $goodIds = array_keys($cart);
                //取购物车的所有商品
                $goods = Goods::find()->where(['in', 'id', $goodIds])->all();
                $shopPrice=0;
                foreach ($goods as $good){
                    //算商品总价
                    $shopPrice+=$good->shop_price*$cart[$good->id];
                }
                //二位小数
                $shopPrice=number_format($shopPrice,2);
                $order->price=$shopPrice+$delivery->delivery_price;

                //订单状态
                $order->status=1;//0:取消1:待付款2:待发货3:待收货4:完成

                //d订单编号
                $order->trade_no=time()+rand(1000,1111);
                //保存数据
                if ($order->save()) {
                    //循环商品存在order_detail
                    foreach ($goods as $good){
                        //判断当前的商品库存是否够
                        //找到当前商品
                        $curGood=Goods::findOne($good->id);
                        //判断库存
                        if ($cart[$good->id]>$curGood->stock) {
                            //提示
                            echo "库存不足";
                            //抛出异常
//                        throw  new Exception("库存不足");
                        }
                        //实例化order_detail
                        $orderDetail=new OrderDetail();
                        //给订单详情表赋值
                        $orderDetail->order_id=$order->id;
//                    var_dump($orderDetail->order_id);
//                    exit();
                        $orderDetail->goods_id=$good->id;
                        $orderDetail->amount=$cart[$good->id];
                        $orderDetail->goods_name=$good->name;
                        $orderDetail->logo=$good->logo;
                        $orderDetail->price=$good->shop_price;
                        $orderDetail->total_price=$good->shop_price*$orderDetail->amount;

                        //保存数据
                        if ($orderDetail->save()) {
                            //减去当前的库存替换之前的库存
                            $curGood->stock=$curGood->stock-$cart[$good->id];
                            //再次保存
                            $orderDetail->save(false);

                        }

                    }
                }
                //清空购物车
                GoodsCart::deleteAll(['user_id'=>$user_id]);

                $transaction->commit();//提交事务

                return Json::encode([
                    'status'=>1,
                    'msg'=>'订单提交成功',
                    'id'=>$order->id,
                ]);

            } catch(Exception $e) {

                $transaction->rollBack();//事务回滚

                return Json::encode([
                    'status'=>0,
                    'msg'=>$e->getMessage(),
                    'id'=>$order->id,
                ]);
            }
        }
    }

    /**
     * 生成订单二维码
     * @param $id 订单ID
     * @return string
     */
    public function actionOk($id)
    {
        //查出当前订单
        $order = Order::findOne($id);
        //载入视图
        return $this->render('flow',compact('order'));

    }

    /**
     * 订单二维码
     * @param $id 订单ID
     */
    public function actionWx($id)
    {
        $order=Order::findOne($id);
        //配置
        $options=\Yii::$app->params['wx'];
//        var_dump($options);exit();
        //创建操作微信的对象
        $app = new Application($options);

        //能过$app得到支付对象
        $payment = $app->payment;

        $attributes = [
            'trade_type'       => 'NATIVE', // JSAPI，NATIVE，APP...
            'body'             => '今夕商城订单',
            'detail'           => '商品详情',
            'out_trade_no'     => $order->trade_no,//订单编号
            'total_fee'        => 1, // 单位：分
            'notify_url'       => Url::to(['order/notify'],true),
            //异步通知路径
            // 支付结果通知网址，如果不设置则会使用配置里的默认地址
//            'openid'           => '当前用户的 openid', // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
            // ...
        ];
        $order = new \EasyWeChat\Payment\Order($attributes);

        //同下订单
        $result = $payment->prepare($order);
//        var_dump($result);exit();
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
//            $prepayId = $result->prepay_id;
            $qrCode = new QrCode($result->code_url);

            header('Content-Type: ' . $qrCode->getContentType());
            echo $qrCode->writeString();
        } else {
            var_dump($result);
        }
    }

    /**
     * 微信异步请求通知
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function actionNotify()
    {
        //配置
        $options=\Yii::$app->params['wx'];
//        var_dump($options);exit();
        //创建操作微信的对象
        $app = new Application($options);
        $response = $app->payment->handleNotify(function($notify, $successful){
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
//            $order = 查询订单($notify->out_trade_no);

            //通过订单号'trade_no'=>$notify->out_trade_no把订单找出来
            $order=Order::findOne(['trade_no'=>$notify->out_trade_no]);
            if (!$order) { // 如果订单不存在
                return '支付失败'; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }

            // 如果订单存在
            // 检查订单是否已经更新过支付状态
            if ($order->status!=1) { // 假设订单字段“支付时间”不为空代表已经支付
                return true; // 已经支付成功了就不再更新了
            }

            // 用户是否支付成功
            if ($successful) {
                // 不是已经支付状态则修改为已经支付状态
//                $order->paid_at = time(); // 更新支付时间为当前时间
                $order->status = 2;//  1:待支付2：待发货
            } else { // 用户支付失败
                $order->status = 'paid_fail';
            }

            $order->save(); // 保存订单

            return true; // 返回处理完成
        });
        return $response;
    }

}
