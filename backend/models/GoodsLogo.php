<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods_logo".
 *
 * @property int $id
 * @property int $goods_id 商品ID
 * @property string $path 图片路径
 */
class GoodsLogo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id'], 'integer'],
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
            'path' => '图片路径',
        ];
    }
}
