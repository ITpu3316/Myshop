<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "mulu".
 *
 * @property int $id
 * @property string $name 名称
 * @property string $ico 样式
 * @property string $url 地址
 * @property int $parend_id 父类ID
 */
class Mulu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'ico', 'url', 'parend_id'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'ico' => '样式',
            'url' => '地址',
            'parend_id' => '父类ID',
        ];
    }
    //声明一个静态方法
    public static function menu(){
//        $menu=[
//            [
//                'label' => '商品',
//                'icon' => 'shopping-bag',
//                'url' => '#',
//                'items' => [
//                    ['label' => '商品列表', 'icon' => 'bars', 'url' => ['/goods/index'],],
//                    ['label' => '商品添加', 'icon' => 'cloud-download', 'url' => ['/goods/add'],],
//                ],
//            ],
//        ];
        //定义一个空数组来存放新的菜单
        $menuAll=[];
        //得到所有的一级目录
        $mulus=self::find()->where(['parend_id'=>0])->all();
        foreach ( $mulus as $mu){

            $newMenu=[];
            $newMenu['label']=$mu->name;
            $newMenu['icon']=$mu->ico;
            $newMenu['url']=$mu->url;

            //通过当前一级目录找到所有的二级目录
            $muluSons=self::find()->where(['parend_id'=>$mu->id])->all();
//            var_dump($muluSons);exit();

            //再次循环
            foreach ( $muluSons as $son) {

                $newMenuSon = [];
                $newMenuSon['label'] = $son->name;
                $newMenuSon['icon'] = $son->ico;
                $newMenuSon['url'] = $son->url;

//                var_dump($newMenuSon);exit();
                $newMenu['items'][]=$newMenuSon;
            }

//            var_dump($newMenu);exit();
            $menuAll[]=$newMenu;

        }

        return $menuAll;
    }
}
