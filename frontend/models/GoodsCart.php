<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "goods_cart".
 *
 * @property int $id
 * @property int $goods_id 商品ID
 * @property int $goods_num 商品数量
 * @property int $user_id
 * @property int $status 状态
 * @property string $created_at 加入时间
 */
class GoodsCart extends \yii\db\ActiveRecord
{
//设置一个时间方法
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
                // if you're using datetime instead of UNIX timestamp:
                // 'value' => new Expression('NOW()'),
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'goods_num'], 'required'],
            [['user_id','status'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => '商品ID',
            'goods_num' => '商品数量',
            'user_id' => '用户ID',
            'status' => '状态',
            'created_at' => '加入时间',
        ];
    }
}
