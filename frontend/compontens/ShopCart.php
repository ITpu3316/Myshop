<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/31 0031
 * Time: 11:26
 */

namespace frontend\compontens;


use frontend\models\GoodsCart;
use yii\base\Component;
use yii\web\Cookie;

class ShopCart extends Component
{
    //声明一个私有的属性来保存数据并调用
    private $cart;

    //创建一个自动调用执行的构造函数
    public function __construct(array $config = [])
    {
        //得到之前的cookie
        $getCookie=\Yii::$app->request->cookies;
        //得到购物车保存的数据
        $this->cart=$getCookie->getValue('cart',[]);
        parent::__construct($config);
    }
    //增
    public function add($id,$num){
        //判断当前添加的商品是否在购物车中存在，如果存在则再次添加，不存在则新增
        if (array_key_exists($id,$this->cart)) {
            $this->cart[$id] += (int)$num;
        }else{
            $this->cart[$id] = (int)$num;
        }
        return $this;
    }
    //删
    public function del($id){
        //删除当前的数据
        unset($this->cart[$id]);
        return $this;
    }

    //改
    public function update($id,$num){
        //修改当前的数据
        if ($this->cart[$id]=$num) {
            $this->cart[$id]=$num;
        }
        return $this;
    }

    //查
    public function get(){
        return $this->cart;
    }
    //清空cookie中的数据
    public function flush(){
        //清空本地购物车
        $this->cart=[];
        return $this;
    }
    //保存
    public function save(){
        //把商品ID($id)当成键,商品数量当成值存放
        //设置一个cookie
        $cartCookie=\Yii::$app->response->cookies;
        //创建一个cookie对象
        $cookie= new Cookie([
            'name'=>'cart',
            'value' => $this->cart,
            'expire' => time()+3600*24*7,
        ]);
        //通过设置的cookie添加cookie对象
        $cartCookie->add($cookie);
    }
    //数据库同步
    public function dbSyn(){
        //当前用户
        $userId=\Yii::$app->user->id;
        foreach ($this->cart as $goodId=>$goodsNum){
            //判断当前用户当前商品有没有存在
            $cartDb=GoodsCart::findOne(['goods_id'=>$goodId,'user_id'=>$userId]);
            //判断
            if ($cartDb){
                //+ 修改操作
                $cartDb->goods_num+=$goodsNum;
                // $cart->save();
            }else{
                //创建对象
                $cartDb=new GoodsCart();
                //赋值
                $cartDb->goods_id=$goodId;
                $cartDb->goods_num=$goodsNum;
                $cartDb->user_id=$userId;
            }
            //保存
            $cartDb->save();
        }
        return $this;
    }

}