<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property int $id
 * @property int $user_id 用户ID
 * @property string $name 收货人
 * @property string $province 省份
 * @property string $city 市
 * @property string $county 区县
 * @property string $address 详细地址
 * @property string $mobile
 * @property int $status 状态
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'province', 'city', 'county', 'address', 'mobile'], 'required'],
            [['mobile'],'match','pattern'=>'/(13|14|15|17|18|19)[0-9]{9}/','message'=>'请输入正确的手机号码'],//验证手机号码
            [['status'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户ID',
            'name' => '收货人',
            'province' => '省份',
            'city' => '市',
            'county' => '区县',
            'address' => '详细地址',
            'mobile' => '手机号码',
            'status' => '状态',
        ];
    }
}
