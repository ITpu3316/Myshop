<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "pay_type".
 *
 * @property int $id
 * @property string $pay_type
 * @property string $pay_detail 简介
 */
class PayType extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pay_type' => 'Pay Type',
            'pay_detail' => '简介',
        ];
    }
}
