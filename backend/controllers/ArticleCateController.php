<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/16 0016
 * Time: 17:05
 */

namespace backend\controllers;


use backend\models\ArticleCate;
use yii\web\Controller;
use yii\web\Request;

class ArticleCateController extends Controller
{
    /**
     * 文章分类展示
     * @return string
     */
    public function actionIndex()
    {
        //得到所有 的数据
        $cates=ArticleCate::find()->all();
        //引入视图
        return $this->render('index',compact('cates'));
    }

    /**
     * 文章分类添加
     * @return string
     *
     */
    public function actionAdd()
    {
        //创建一个model对象
        $model=new ArticleCate();
        //创建一个requerst对象
        $request=new Request();
        //创建post传值
        if ($request->isPost) {
            //绑定数据
            $model->load($request->post());
            //后台验证
            if ($model->validate()) {
                //保存数据
                if ($model->save()) {
                    //提示信息
                    \Yii::$app->session->setFlash('success','恭喜你！添加成功');
                    //跳转页面
                    return $this->redirect(['index']);
                }
            }else{
                //TODO:打印错误
//                var_dump($model->getErrors());exit;
            }

        }
        //引入视图
        return $this->render('add',compact('model'));


    }

    /**
     * 编辑文章分类
     * @param $id 分类ID
     * @return string|\yii\web\Response
     *
     */
    public function actionEdit($id)
    {
        //创建一个model对象
        $model=ArticleCate::findOne($id);
        //创建一个requerst对象
        $request=new Request();
        //创建post传值
        if ($request->isPost) {
            //绑定数据
            $model->load($request->post());
            //后台验证
            if ($model->validate()) {
                //保存数据
                if ($model->save()) {
                    //提示信息
                    \Yii::$app->session->setFlash('success','恭喜你！添加成功');
                    //跳转页面
                    return $this->redirect(['index']);
                }
            }else{
                //打印错误
                var_dump($model->getErrors());exit;
            }

        }
        //引入视图
        return $this->render('add',compact('model'));


    }

    /**
     * 删除分类列表
     * @param $id 分类ID
     * @return \yii\web\Response
     */
    public function actionDel($id)
    {
        //删除数据
        if ($article=ArticleCate::findOne($id)->delete()) {
            //提示信息
            \Yii::$app->session->setFlash('danger','恭喜你！删除成功');
            //跳转页面
            return $this->redirect(['index']);

        }

    }


}