<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property int $Id
 * @property string $name 图书名称
 * @property string $money 价格
 * @property string $sn 图书编号
 * @property int $create_time 上架时间
 * @property string $isget 是否上架
 * @property string $detail 图书简介
 * @property int $logo 图像
 */
class Book extends \yii\db\ActiveRecord
{
    public static $isget=[1=>'上架',2=>'下架'];

    //设置一个属性
    public $code;
    public $imgFile;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','money','sn','isget','detail'], 'required'],
            [['money'],'number'],
            [['cate_id'],'safe'],
            [['imgFile'],'image','extensions' =>['gif','jpg','png'],"skipOnEmpty" => true ],
            [['code'],'captcha','captchaAction' => 'book/code'],//验证码规则
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => '图书名称',
            'money' => '价格',
            'sn' => '图书编号',
            'isget' => '是否上架',
            'detail' => '图书简介',
            'imgFile'=>'缩略图',
            'code'=>'验证码',
            'cate_id'=>'分类ID'
        ];
    }
    //4.1对1
    public function getContent(){

        return $this->hasOne(Author::className(),['id'=>'cate_id']);

    }

}
