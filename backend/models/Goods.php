<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "goods".
 *
 * @property int $id
 * @property string $name 名称
 * @property string $sn 货号
 * @property int $logo 商品头像
 * @property int $goods_category_id 分类ID
 * @property int $brand_id 品牌ID
 * @property string $market_price 市场价格
 * @property string $shop_price 本地价格
 * @property int $stock 库存
 * @property int $status 是否上架
 * @property int $sort 排序
 * @property int $create_time 录入时间
 */
class Goods extends \yii\db\ActiveRecord
{
    //设置一个时间方法
    public function behaviors()
    {
        return [
            [

                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['create_time'],
                ],
                // if you're using datetime instead of UNIX timestamp:
                // 'value' => new Expression('NOW()'),
            ],
        ];
    }
    public static $ses=['0'=>'下架','1'=>'上架'];
    public $images;
//    public $detail;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','market_price', 'shop_price','stock','status' ], 'required'],
            [['goods_category_id','brand_id','sort','logo','images','sn'],'safe']
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
            'sn' => '货号',
            'logo' => '商品LOGO',
            'images' => '商品图片',
            'goods_category_id' => '所属分类',
            'brand_id' => '所属品牌',
            'market_price' => '市场价格',
            'shop_price' => '本地价格',
            'stock' => '库存',
            'status' => '是否上架',
            'sort' => '排序',
            'detail' => '商品详情',
        ];
    }

    /**
     * 获取数据此时
     * 一对一
     */
    public function getContents()
    {
        //获取数据
        return $this->hasOne(GoodsIntro::className(),['goods_id'=>'id']);

    }
    public function getCategorys()
    {
        //获取数据
        return $this->hasOne(Category::className(),["id"=>"goods_category_id"]);

    }
    public function getBrands()
    {
        //获取数据
        return $this->hasOne(Brand::className(),['id'=>'brand_id']);

    }
    //得到商品的图片 一对多
    public function getImas(){
        //获取数据
        return $this->hasMany(GoodsLogo::className(),['goods_id'=>'id']);
    }

}
