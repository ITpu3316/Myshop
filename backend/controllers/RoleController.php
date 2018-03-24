<?php

namespace backend\controllers;

use backend\models\AuthItem;
use yii\helpers\ArrayHelper;
use yii\rbac\Item;

class RoleController extends \yii\web\Controller
{
    /**
     * 角色列表
     * @return string
     */
    public function actionIndex()
    {
        //创建auth对象
        $auth=\Yii::$app->authManager;
        //找到所有的角色
        $roles=$auth->getRoles();
        //载入视图
        return $this->render('index',compact('roles'));
    }

    /**
     * 角色添加
     * @return string|\yii\web\Response
     */
    public function actionAdd(){

        //创建模型对象
        $model=new AuthItem();
        //创建auth对象
        $auth=\Yii::$app->authManager;
        //得到所有的角色
        $itrm=$auth->getPermissions();
        //转换成一维数组
        $itrmArr=ArrayHelper::map($itrm,'name','description');
//        var_dump($itrmArr);exit();
        //判断是不是post提交以及验证
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
//          //创建auth对象
//          $auth=\Yii::$app->authManager;
            //创建角色
            $role=$auth->createRole($model->name);
            //创建描述
            $role->description=$model->description;
            //分配权限到库中
            if ($auth->add($role)) {
                //判断有没有添加权限
                if ($model->permissions) {
                    //给当前角色添加权限 此时循环取出权限给角色
                    foreach($model->permissions as $perName){
                        //通过权限名取得权限对象
                        $per=$auth->getPermission($perName);
                        //给角色添加权限
                        $auth->addChild($role,$per);
                    }
                }
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
        return $this->render('add',compact('model','itrmArr'));
    }

    /**
     * 角色编辑
     * @param $name 角色名称
     * @return string|\yii\web\Response
     */
    public function actionEdit($name){

        //创建模型对象
        $model=AuthItem::findOne($name);
        //创建auth对象
        $auth=\Yii::$app->authManager;
        //得到所有的权限
        $itrm=$auth->getPermissions();
        //转换成一维数组
        $itrmArr=ArrayHelper::map($itrm,'name','description');
//        var_dump($itrmArr);exit();
        //判断是不是post提交以及验证
        if($model->load(\Yii::$app->request->post()) && $model->validate()){

//            //创建auth对象
//            $auth=\Yii::$app->authManager;

            //得到角色
            $role=$auth->getRole($model->name);

            //创建描述
            $role->description=$model->description;

            //更新角色
            if ($auth->update($model->name,$role)) {
                //在编辑之前吧所有 的权限删除
                $auth->removeChildren($role);

                //判断有没有添加权限
                if ($model->permissions) {
                    //给当前角色添加权限 此时循环取出权限给角色
                    foreach($model->permissions as $perName){

                        //通过权限名取得权限对象
                        $per=$auth->getPermission($perName);

                        //给角色添加权限
                        $auth->addChild($role,$per);

                    }
                }


                //显示提示信息
                \Yii::$app->session->setFlash('success','恭喜你!添加成功');
                //跳转页面
                return $this->redirect(['index']);

            }

        }else{
            //打印错误信息
//            var_dump($model->getErrors());exit;
        }
        //得到当前所有的权限
        $rolePers=$auth->getPermissionsByRole($name);

        //取$rolePers中的所有key值组成一个新的数组
//        var_dump(array_keys($rolePers));exit();
        //给权限回显数据
        $model->permissions=array_keys($rolePers);
        //载入视图
        return $this->render('edit',compact('model','itrmArr'));

    }
    /**
     * 角色删除
     * @param $name 角色名称
     * @return \yii\web\Response
     */
    public function actionDel($name){
        //创建auth对象
        $auth=\Yii::$app->authManager;

        //找到角色
        $role=$auth->getRole($name);

        //删除数据
        if ($auth->remove($role)) {
            //显示提示信息
            \Yii::$app->session->setFlash('danger','恭喜你!删除'.$name.'成功');
            //跳转页面
            return $this->redirect(['index']);
        }

    }

    /**
     * 给用户添加一个角色
     * @param $roleName角色名称
     */
    public function actionAdminRole($roleName,$id){
        //创建auth对象
        $auth=\Yii::$app->authManager;
        //通过角色名称找出对应的角色对象
        $role=$auth->getRole($roleName);
        //给用户指派角色
        $auth->assign($role,$id);

    }

    /**
     * 判断当前用户有没有权限
     */
    public function actionCheck(){

        var_dump(\Yii::$app->user->can('goods/add'));

    }
}
