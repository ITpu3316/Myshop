<?php

namespace backend\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "admin".
 *
 * @property int $id
 * @property string $name
 * @property int $password
 * @property int $sex 性别
 * @property int $image 图片
 */
class Brand extends ActiveRecord
{

    public static $sexs=[1=>'上架',2=>'下架'];
    /**
     * @inheritdoc
     */
    //设置一个默认的属性
    public function rules()
    {
        return [
            [['name', 'sort','status','intro','logo'], 'required'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '品牌名称',
            'logo' => '品牌头像',
            'sort' => '品牌排序',
            'status' => '品牌状态',
            'intro'=>'品牌简介'
        ];
    }
}
