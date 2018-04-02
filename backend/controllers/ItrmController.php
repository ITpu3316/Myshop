<?php

namespace backend\controllers;

use backend\models\AuthItem;
use yii\rbac\Item;

class ItrmController extends \yii\web\Controller
{
    /**
     * 权限列表
     * @return string
     */
    public function actionIndex()
    {
        //创建auth对象
        $auth=\Yii::$app->authManager;
        //找到所有的权限
        $items=$auth->getPermissions();
        //载入视图
        return $this->render('index',compact('items'));
    }

    /**
     * 权限添加
     * @return string|\yii\web\Response
     */
    public function actionAdd(){

        //创建模型对象
        $model=new AuthItem();

        //判断是不是post提交以及验证
        if($model->load(\Yii::$app->request->post()) && $model->validate()){

            //创建auth对象
            $auth=\Yii::$app->authManager;

            //创建权限
            $per=$auth->createPermission($model->name);

            //创建描述
            $per->description=$model->description;

            //分配权限到数据库中
            if ($auth->add($per)) {
                //显示提示信息
                \Yii::$app->session->setFlash('success','恭喜你!添加成功');
                //跳转页面
                return $this->redirect(['index']);

            }

        }else{
            //打印错误信息
//            var_dump($model->getErrors());exit;
        }

        //载入视图
        return $this->render('add',compact('model'));

    }

    /**
     * 权限编辑
     * @param $name 权限名称
     * @return string|\yii\web\Response
     */
    public function actionEdit($name){

        //创建模型对象
        $model=AuthItem::findOne($name);

        //判断是不是post提交以及验证
        if($model->load(\Yii::$app->request->post()) && $model->validate()){

            //创建auth对象
            $auth=\Yii::$app->authManager;

            //得到权限
            $per=$auth->getPermission($model->name);

            //创建描述
            $per->description=$model->description;

            //分配权限到数据库中
            if ($auth->update($model->name,$per)) {
                //显示提示信息
                \Yii::$app->session->setFlash('success','恭喜你!编辑成功');
                //跳转页面
                return $this->redirect(['index']);

            }

        }else{
            //打印错误信息
//            var_dump($model->getErrors());exit;
        }

        //载入视图
        return $this->render('edit',compact('model'));

    }

    /**
     * 权限删除
     * @param $name 权限名称
     * @return \yii\web\Response
     */
    public function actionDel($name){
        //创建auth对象
        $auth=\Yii::$app->authManager;

        //找到权限
        $per=$auth->getPermission($name);

        //删除数据
        if ($auth->remove($per)) {
            //显示提示信息
            \Yii::$app->session->setFlash('danger','恭喜你!删除'.$name.'成功');
            //跳转页面
            return $this->redirect(['index']);
        }


    }

}
