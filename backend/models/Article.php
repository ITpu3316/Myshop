<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $name 文章主题
 * @property int $cate_id 分类id
 * @property string $intro 简介
 * @property int $status 状态
 * @property int $sort 排序
 * @property int $create_time 录入时间
 * @property int $upload_time 修改时间
 */
class Article extends \yii\db\ActiveRecord
{
    //设置一个时间方法
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['create_time', 'upload_time'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['upload_time'],
                ],
                // if you're using datetime instead of UNIX timestamp:
                // 'value' => new Expression('NOW()'),
            ],
        ];
    }
    public static $status;
    public $detail;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort', 'name', 'intro','sort'], 'required'],
            [['cate_id','status'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '文章主题',
            'cate_id' => '分类id',
            'intro' => '简介',
            'status' => '状态',
            'sort' => '排序',
            'create_time' => '录入时间',
            'upload_time' => '修改时间',
            'detail'=>'文章内容'
        ];
    }

    /**
     * 一对一
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(ArticleCate::className(),['id'=>'cate_id']);

    }

    public function getContents()
    {
        return $this->hasOne(ArticleContent::className(),['article_id'=>'id']);

    }
}
