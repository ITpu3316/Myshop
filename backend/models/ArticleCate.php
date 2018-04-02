<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article_cate".
 *
 * @property int $id
 * @property string $cate_name 文章分类
 */
class ArticleCate extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cate_name'], 'required'],
            [['cate_name'],'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cate_name' => '文章分类',
        ];
    }
}
