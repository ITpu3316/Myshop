<?php

namespace backend\controllers;

use backend\models\Admin;
use backend\models\AuthItem;
use backend\models\LoginForm;
use yii\helpers\ArrayHelper;
use yii\web\Request;
use yii\web\UploadedFile;

class AdminController extends \yii\web\Controller
{
    /**
     * 显示用户列表
     * @return string
     *
     */
    public function actionIndex(){
        //获取所有的数据
        $admins=Admin::find()->all();
        //载入视图
        return $this->render('index',compact('admins'));

    }

    /**
     *用户添加
     * @return string|\yii\web\Response
     *
     */
    public  function  actionAdd(){
        $admin=new  Admin();
        $admin->setScenario('add');
        //找到所有的角色
        $adminRoles=AuthItem::find()->where("type=1")->asArray()->all();
        $adminRole=ArrayHelper::map($adminRoles,"name","name");
//          var_dump($adminRole);exit;
        $request=\Yii::$app->request;
        if($request->isPost){

            //保存数据
            $admin->load($request->post());

            //后台验证
            if($admin->validate()){

                //给密码加密
                $admin->password=\Yii::$app->security->generatePasswordHash($admin->password);
                //随机生成令牌
                $admin->token=\Yii::$app->security->generateRandomString();
                $admin->add_time=time();
                if($admin->save()){
//                      var_dump($admin->id);exit;
                    $id=$admin->id;
                    //添加权限
                    $auth=\Yii::$app->authManager;
                    $role=$auth->getRole($admin->adminRole);
//                    var_dump($role);exit();
                    $auth->assign($role,$id);

                    \Yii::$app->session->setFlash("success","添加成功");
                    return $this->redirect(["index"]);
                }
            }else{
                //打印错误
                var_dump($admin->getErrors());exit;
            }
        }
        //载入视图
        return $this->render("add",compact("admin","adminRole"));
    }


    /**
     * 退出登录
     * @return \yii\web\Response
     */
    public function actionOut(){
        \Yii::$app->user->logout();

        return $this->goHome();

    }


    /**
     * 管理员编辑
     * @param $id 用户ID
     * @return string|\yii\web\Response
     *
     */
    public function actionEdit($id){
        //建立model对象
        $model=Admin::findOne($id);
        //建立requert对象
        $request=new Request();
        //设置场景
        $model->setScenario('edit');
        //保存原来的密码
        $password=$model->password;
        //判断是否是post传值
        if ($request->isPost) {
            //绑定数据
            $model->load($request->post());
            //后台验证
            if ($model->validate()) {
                //给密码加密
                $model->password=$model->password?\Yii::$app->security->generatePasswordHash($model->password):$password;
                //设置令牌 产生32的随机数
//                $model->token=\Yii::$app->security->generateRandomString();
                //保存最后的时间
                $model->add_time=time();
                $model->save();
                //保存数据
                if ($model->save()) {
                    //显示提示信息
                    \Yii::$app->session->setFlash('success','恭喜你!编辑成功');
                    //跳转页面
                    return $this->redirect(['index']);
                }

            }else{
                //打印错误信息
                var_dump($model->getErrors());exit;
            }
        }
        $model->password=null;
        //载入视图
        return $this->render('add',compact('model'));

    }

    /**
     * 用户登录
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        //生成一个登录表单
        $model=new LoginForm();
        //创建一个request的对象
        $request=new Request();
        //判断post提交
        if ($request->isPost) {
            //保存数据
            $model->load($request->post());
            //后台验证
            if ($model->validate()) {
                //通过用户名找到对应的数据
                $admin = Admin::find()->where(['username' => $model->username, 'status' => 1])->one();
                //验证用户名是不是存在
                if ($admin) {
//                var_dump($admin->password);exit();
                    //用户名存在通过数据库找到对应的密码,验证密码$admin->password==$model->password
                    if (\Yii::$app->security->validatePassword($model->password, $admin->password)) {
                        //获取当前用户的IP
                        $admin->ip = ip2long(\Yii::$app->request->userIP);
                        //保存最后的时间
                        $admin->last_time = time();
                        $admin->save();
//                        var_dump($admin->errors);exit;
                        //通过设置的user组件来实现登录
                        \Yii::$app->user->login($admin, $model->rememberMe ? 3600 * 24 * 7 : 0);
                        //跳转页面
                        \Yii::$app->session->setFlash('success', '登录成功');
                        return $this->redirect(['index']);

                    } else {
                        //密码不正确时
                        $model->addError('password', '密码错误');
                    }

                }else {
                    //用户名不存在
                    $model->addError('username', '用户名不正确');
                }
            } else {
                //打印错误
                var_dump($model->getErrors());
                exit();
            }
//            var_dump($admin);exit();

        }
        //载入视图
        return $this->render('login',compact('model'));
    }

}
