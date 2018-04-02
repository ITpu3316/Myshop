<?php

namespace frontend\controllers;

use backend\models\Goods;

class GoodsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }


    /**
     * 商品详情
     * @param $id商品ID
     */
    public function actionDetail($id){

        //获取所有的数据
        $details=Goods::findOne($id);
//        var_dump($details);exit();
        //载入视图
        return $this->render('detail',compact('details'));

    }

}
