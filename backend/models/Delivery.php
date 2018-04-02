<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "delivery".
 *
 * @property int $id
 * @property string $delivery_name 配送方式
 * @property string $delivery_price 运费
 */
class Delivery extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'delivery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['delivery_name', 'delivery_price'], 'required'],
            [['delivery_price'], 'number'],
            [['delivery_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'delivery_name' => '配送方式',
            'delivery_price' => '运费',
        ];
    }
}
