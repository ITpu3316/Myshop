<?php

namespace frontend\controllers;

use backend\models\Category;
use backend\models\Goods;

class IndexController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 分类列表
     * @param $id 分类ID
     * @return string
     */
    public function actionList($id)
    {
        //通过分类ID得到当前的对象
        $cate=Category::findOne($id);
        //通过当前分类ID找出所有的子分类
        $cateSon=Category::find()->andWhere(['tree'=>$cate->tree])->andWhere("lft>={$cate->lft}")->andWhere("rgt<={$cate->rgt}")->asArray()->all();
        //把得到的数据转换成一维数组
        $cateId=array_column($cateSon,'id');
//        var_dump($cateId);exit();
        //得到当前分类的所有数据
        $goodds=Goods::find()->where(['in','goods_category_id',$cateId])->andWhere(['status'=>1])->orderBy('sort')->all();

//        var_dump($goodds);exit();
        //载入视图
        return $this->render('list',compact('goodds'));

    }

}
