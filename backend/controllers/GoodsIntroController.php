<?php

namespace backend\controllers;

use backend\models\GoodsIntro;

class GoodsIntroController extends \yii\web\Controller
{
    /**
     * 展示商品详情
     * @return string
     *
     */
    public function actionIndex()
    {
        //获取所有的数据
        $intros=GoodsIntro::find()->all();
        //载入视图
        return $this->render('index',compact('intros'));
    }

}
