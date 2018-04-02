<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $user_id 会员ID
 * @property string $name 收货人
 * @property string $procince 省份
 * @property string $city 市
 * @property string $county 区县
 * @property string $address 详细地址
 * @property string $mobile 电话号码
 * @property int $delivery_id 配送方式
 * @property string $delivery_name 配送地址
 * @property string $delivery_price 运费
 * @property int $pay_type_id 支付方式
 * @property string $pay_type_price 支付方式
 * @property string $trade_no 订单编号
 * @property int $status 状态
 * @property string $price 总金额
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '会员ID',
            'name' => '收货人',
            'procince' => '省份',
            'city' => '市',
            'county' => '区县',
            'address' => '详细地址',
            'mobile' => '电话号码',
            'delivery_id' => '配送方式',
            'delivery_name' => '配送地址',
            'delivery_price' => '运费',
            'pay_type_id' => '支付方式',
            'pay_type_name' => '支付方式',
            'trade_no' => '订单编号',
            'status' => '状态',
            'price' => '总金额',
        ];
    }
}
