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
use yii\web\Request;

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
                    'msg'=>'订单提交成功'
                ]);

            } catch(Exception $e) {

                $transaction->rollBack();//事务回滚

                return Json::encode([
                    'status'=>0,
                    'msg'=>$e->getMessage()
                ]);
            }
        }
        return $this->render('flow');
    }

}
