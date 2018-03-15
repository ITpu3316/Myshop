<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/13 0013
 * Time: 18:24
 */

namespace frontend\controllers;


use frontend\filters\RbacFilter;
use frontend\models\Admin;
use frontend\models\LoginForm;
use yii\captcha\CaptchaAction;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Request;
use yii\web\UploadedFile;
use Yii;

class AdminController extends TestController
{
    //验证码
    public function actions()
    {
        return [
            'code' => [
                'class' => CaptchaAction::className(),
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'maxLength' => 4, //最大长度
                'minLength' => 4 //最小长度
            ],
        ];
    }
    //显示列表
    public function actionIndex(){
        //获取数据
        $query=Admin::find();
        //计算数的总条据数  每一页显示的条数   当前页
        $count = $query->count();
        //创建每一页的对象
        $page=new Pagination([
            'pageSize' => 3,//每页显示条数
            'totalCount' => $count,//总条数
        ]);

        $admins=$query->offset($page->offset)->limit($page->limit)->all();
        //载入视图
        return $this->render('index',compact('admins','page'));
    }
    //添加数据
    public function actionAdd()
    {
        //建立model对象
        $model=new Admin();
        //建立requert对象
        $request=new Request();
        //判断是否是post传值
        if ($request->isPost) {
            //得到图片上传的对象
            $model->images=UploadedFile::getInstance($model,'images');
            //先定义一个空的
            $images="";
            //判断上传的对象是否为null
            if($model->images!==null){
                //定义文件上传的路过
                $images="images/".time().".".$model->images->extension;
                //把文件移动临时目录中
                $model->images->saveAs($images,false);

            }
            //绑定数据
            $model->load($request->post());
            //后台验证
            if ($model->validate()) {
                //把临时文件上传到数据库中
                $model->image=$images;

                //保存数据
                if ($model->save(false)) {
                    //显示提示信息
                    \Yii::$app->session->setFlash('success','恭喜你!注册成功');
                    //跳转页面
                    return $this->redirect(['index']);
                }

            }else{
                //打印错误信息
                var_dump($model->getErrors());exit;
            }
        }
        //载入视图
        return $this->render('add',compact('model'));

    }

    //修改数据
    public function actionEdit($id)
    {
        //建立model对象
        $model=Admin::findOne($id);
        //建立requert对象
        $request=new Request();
        //判断是否是post传值
        if ($request->isPost) {
            //得到图片上传的对象
            $model->images=UploadedFile::getInstance($model,'images');
            //先定义一个空的
            $images="";
            //判断上传的对象是否为null
            if($model->images!==null){
                //定义文件上传的路过
                $images="images/".time().".".$model->images->extension;
                //把文件移动临时目录中
                $model->images->saveAs($images,false);

            }
            //绑定数据
            $model->load($request->post());
            //后台验证
            if ($model->validate()) {
                //把临时文件上传到数据库中
                $model->image=$images;

                //保存数据
                if ($model->save(false)) {
                    //显示提示信息
                    \Yii::$app->session->setFlash('success','恭喜你!注册成功');
                    //跳转页面
                    return $this->redirect(['index']);
                }

            }else{
                //打印错误信息
                var_dump($model->getErrors());exit;
            }
        }
        //载入视图
        return $this->render('add',compact('model'));

    }

    //删除数据
    public function actionDel($id)
    {
        //删除数据
        if ($admins=Admin::findOne($id)->delete()) {
            //跳转页面
            return $this->redirect(['index']);
        }

    }

    //登录
    public function actionLogin()
    {
        //生成一个表单模型
        $model=new LoginForm();
        //创建一个request对象
        $request=new Request();
        //post提交验证
        if($request->isPost){
            //绑定数据
            $model->load($request->post());
            //用过用户名找到对应的数据
            $admin=Admin::find()->where(['name'=>$model->name])->one();
            //验证用户名是否存在
            if($admin){

                //用户名存在通过数据库找到对应的密码,验证密码
                if($admin->password==$model->password){

                    //通过设置的user组件来实现登录
                    \Yii::$app->user->login($admin);

                    //跳转页面
                    \Yii::$app->session->setFlash('success','登录成功');
                    return $this->redirect(['index']);


                }else{
                    //密码不正确时
                    //\Yii::$app->session->setFlash('danger','密码错误');
                    $model->addError('password','密码错误');
                }

            }else{
                //用户名不存在
                //\Yii::$app->session->setFlash('danger','用户名不正确');
                $model->addError('name','用户名不正确');

            }

        }
        return $this->render('login',compact('model'));

    }

}