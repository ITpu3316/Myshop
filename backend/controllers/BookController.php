<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/12 0012
 * Time: 18:01
 */

namespace frontend\controllers;


use frontend\models\Author;
use frontend\models\Book;
use yii\captcha\CaptchaAction;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Request;
use yii\web\UploadedFile;

class BookController extends Controller
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
        $query=Book::find();
        //计算数据的总条数  每一页显示的条数   当前页
        $count = $query->count();
        //创建每一页的对象
        $page=new Pagination([
            'pageSize' => 3,//每页显示条数
            'totalCount' => $count,//总条数
        ]);

        $books=$query->offset($page->offset)->limit($page->limit)->all();
        //载入视图
        return $this->render('index',compact('books','page'));
    }
    
    //添加数据
    public function actionAdd()
    {
        //建立model对象
        $model=new Book();
        //创建一个得到所有分类的数据
        $cates=Author::find()->asArray()->all();
//        var_dump($cates);exit();
        //把二维数组转化成一维数组
        $catesArr=ArrayHelper::map($cates,'id','author');
//        var_dump($catesArr);exit();

        //建立requert对象
        $request=new Request();
        //判断是否是post传值
        if ($request->isPost) {

            //第一步，得到上传图像对象
            $model->imgFile=UploadedFile::getInstance($model,'imgFile');
//            var_dump($model->errors);exit;
            //先定义一个空的
            $imgPath="";
            if ($model->imgFile!==null){
                //第二步，定义文件上传后的路径
                $imgPath="images/".time().".".$model->imgFile->extension;
                //第三步，移动临时文件到$imgPath中
                $model->imgFile->saveAs($imgPath,false);
            }
            //绑定数据
            $model->load($request->post());

            //后台验证
            if ($model->validate()) {

                //获取插入的时间
                $model->create_time=time();

                //第四步，把临时文件的路径保存到logo中
                $model->logo=$imgPath;
//                var_dump($model->errors);

                //保存数据
                if ($model->save(false)) {
//                    var_dump($model->errors);exit;
                    //显示提示信息
                    \Yii::$app->session->setFlash('success','恭喜你!添加成功');
                    //跳转页面
                    return $this->redirect(['index']);
                }
                var_dump($model->errors);exit;
            }else{
                //打印错误信息
                var_dump($model->getErrors());exit;
            }
        }
        //载入视图
        return $this->render('add',compact('model','catesArr'));

    }

    //编辑数据
    public function actionEdit($id)
    {
        //建立model对象
        $model=Book::findOne($id);
        //创建一个得到所有分类的数据
        $cates=Author::find()->asArray()->all();
//        var_dump($cates);exit();
        //把二维数组转化成一维数组
        $catesArr=ArrayHelper::map($cates,'id','author');
//        var_dump($catesArr);exit();

        //建立requert对象
        $request=new Request();
        //判断是否是post传值
        if ($request->isPost) {

            //第一步，得到上传图像对象
            $model->imgFile=UploadedFile::getInstance($model,'imgFile');
//            var_dump($model->errors);exit;
            //先定义一个空的
            $imgPath="";
            if ($model->imgFile!==null){
                //第二步，定义文件上传后的路径
                $imgPath="images/".time().".".$model->imgFile->extension;
                //第三步，移动临时文件到$imgPath中
                $model->imgFile->saveAs($imgPath,false);
            }
            //绑定数据
            $model->load($request->post());

            //后台验证
            if ($model->validate()) {

                //获取插入的时间
                $model->create_time=time();

                //第四步，把临时文件的路径保存到logo中
                $model->logo=$imgPath;
//                var_dump($model->errors);

                //保存数据
                if ($model->save(false)) {
//                    var_dump($model->errors);exit;
                    //显示提示信息
                    \Yii::$app->session->setFlash('success','恭喜你!编辑成功');
                    //跳转页面
                    return $this->redirect(['index']);
                }
                var_dump($model->errors);exit;
            }else{
                //打印错误信息
                var_dump($model->getErrors());exit;
            }
        }
        //载入视图
        return $this->render('add',compact('model','catesArr'));

    }

    //删除数据
    public function actionDel($id)
    {
        //删除数据
        if ($books=Book::findOne($id)->delete()) {
            //跳转页面
            return $this->redirect(['index']);
        }

    }

}