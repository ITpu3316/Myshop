<?php

namespace frontend\controllers;

use backend\models\Goods;
use frontend\compontens\ShopCart;
use frontend\models\GoodsCart;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Cookie;
use yii\web\Request;

class GoodsCartController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 购物车添加
     * @param $id 商品ID
     * @param $amount 商品数量
     */
    public function actionAddCart($id,$amount){
        //判断是否已经登录
        if (\Yii::$app->user->isGuest) {
            //未登录 存在cookie中
            //调用封装的组件(类)
            (new ShopCart())->add($id,$amount)->save();
            //得到之前的cookie
//            $getCookie=\Yii::$app->request->cookies;
//            //得到购物车保存的数据
//            $cart=$getCookie->getValue('cart',[]);
////            var_dump(array_key_exists($id,$cart));exit();
////            //判断当前添加的商品是否在购物车中存在，如果存在则再次添加，不存在则新增
//            if (array_key_exists($id,$cart)) {
//                $cart[$id] += (int)$amount;
//            }else{
//                $cart[$id] = (int)$amount;
//            }
////            var_dump($cart);exit();
//            //把商品ID($id)当成键,商品数量当成值存放
//            //设置一个cookie
//            $cartCookie=\Yii::$app->response->cookies;
//            //创建一个cookie对象
//            $cookie= new Cookie([
//                'name'=>'cart',
//                'value' => $cart,
//            'expire' => time()+3600*24*7,
//            ]);
//            //通过设置的cookie添加cookie对象
//            $cartCookie->add($cookie);

        }else{
            //已经登录 存在数据库
            //查询出购物车中当前用户的购物车数据
            $cartGoods=GoodsCart::find()->where(['goods_id'=>$id,'user_id'=>\Yii::$app->user->identity->id])->one();
//            var_dump($cartGoods);exit();
            //2 如果数据库中的待支付数据为空直接写入当前数据
            if (empty($cartGoods)) {
                $cartModel = new GoodsCart();
                $cartModel->goods_id = $id;
                $cartModel->goods_num = $amount;
                $cartModel->user_id = \Yii::$app->user->identity->id;
                $cartModel->status = 0;
                if ($cartModel->save() === false) {
                    echo '加入购物车失败';
                    exit;
                }
            }else{
                //3 如果不为空则将新添加的数据更新到当前商品
                $cartGoods->goods_num += $amount;
                if ($cartGoods->save() === false) {
                    echo '加入购物车失败';
                    exit;
                }
            }
        }
        return $this->redirect(['goods-cart/cart-list']);
//        var_dump($id,$amount);
    }

    /**
     * 购物车列表
     * @return string
     */
    public function actionCartList(){
        //判断是否登录
        if (\Yii::$app->user->isGuest) {
            //未登录
            //从cookie中取出数据
            $cart=\Yii::$app->request->cookies->getValue('cart',[]);
            //取出$cart中的所有key值
            $goodsId=array_keys($cart);
            //取购物车的所有商品
            $goos=Goods::find()->where(['in','id',$goodsId])->all();
//            var_dump($goods);exit();
        }else{
            //未登录 查询出所有的数据
            //从cookie中取出购物车数据
            //  $cart = \Yii::$app->request->cookies->getValue('cart', []);
            $cart=GoodsCart::find()->where(['user_id'=>\Yii::$app->user->id])->all();
            //把二维数组提取成一维数组 [‘商品Id’=>商品数量,...]
            $cart=ArrayHelper::map($cart,'goods_id','goods_num');
            //  var_dump($cart);exit;
            //取出$cart中的所有key值
            $goodIds = array_keys($cart);
            //取购物车的所有商品
            $goos=Goods::find()->where(['in', 'id', $goodIds])->all();
//            var_dump($goos);exit();

        }
        return $this->render('list',compact('goos','cart'));
    }

    /**
     * 修改购物车
     * @param $id 商品ID
     * @param $amount 商品数量
     */
    public function actionUpdateCart($id,$amount){
        //判断是否登录
        if (\Yii::$app->user->isGuest) {
            //未登录
            (new ShopCart())->update($id,$amount)->save();
            //从cookie中取出数据
//            $cart=\Yii::$app->request->cookies->getValue('cart',[]);
//            //修改对应的数据
//            $cart[$id]=$amount;
//            //把$cart存在购物车中
//            //把商品ID($id)当成键,商品数量当成值存放
//            //设置一个cookie
//            $cartCookie=\Yii::$app->response->cookies;
//            //创建一个cookie对象
//            $cookie= new Cookie([
//                'name'=>'cart',
//                'value' => $cart,
//            ]);
//            //通过设置的cookie添加cookie对象
//            $cartCookie->add($cookie);
        }else{
            //未登录 链接数据库
            //查询出用户所有需要结算的购物车数据
            $mysqlCart = GoodsCart::find()->where(['user_id'=>\Yii::$app->user->identity->id, 'status'=>0])->asArray()->all();
//            var_dump($mysqlCart);exit();
            $goos = [];
            $cart = [];
            //构造和cookie相同的数据结构
            if (!empty($mysqlCart)) {
                foreach($mysqlCart as $v){
                    $cart[$v['goods_id']] = $v['goods_num'];
                }
                $goos = Goods::findAll(array_keys($cart));
//                var_dump($goods);exit();
            }
        }
    }

    /**
     * 删除数据
     * @param $id 商品ID
     */
    public function actionDelCart($id){
        //判断是否登录
        if (\Yii::$app->user->isGuest) {
            //未登录
            (new ShopCart())->del($id)->save();
//            //从cookie中取出数据
//            $cart=\Yii::$app->request->cookies->getValue('cart',[]);
//            //删除对应的数据
//            unset($cart[$id]);
//            //把$cart存在购物车中
//            //把商品ID($id)当成键,商品数量当成值存放
//            //设置一个cookie
//            $cartCookie=\Yii::$app->response->cookies;
//            //创建一个cookie对象
//            $cookie= new Cookie([
//                'name'=>'cart',
//                'value' => $cart,
//            ]);
//            //通过设置的cookie添加cookie对象
//            $cartCookie->add($cookie);
            //
            return Json::encode([
                'status'=>1,
                'msg'=>'删除成功'

            ]);
        }else{
            //未登录 链接数据库
            // 查询出用户所有需要结算的购物车数据
            $mysqlCart = GoodsCart::find()->where(['user_id'=>\Yii::$app->user->identity->id, 'status'=>0])->asArray()->all();
//            var_dump($mysqlCart);exit();
            $goos = [];
            $cart = [];
            // 构造和cookie相同的数据结构
            if (!empty($mysqlCart)) {
                foreach($mysqlCart as $v){
                    $cart[$v['goods_id']] = $v['goods_num'];
                }
                $goos = Goods::findAll(array_keys($cart));
//                var_dump($goods);exit();
            }
        }
    }

    /**
     * 测试购物车
     */
    public function actionTest(){
        $getCookie=\Yii::$app->request->cookies;
        var_dump($getCookie->getValue('cart'));

    }


}
