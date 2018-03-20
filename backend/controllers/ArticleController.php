<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/16 0016
 * Time: 18:14
 */

namespace backend\controllers;


use backend\models\Article;
use backend\models\ArticleCate;
use backend\models\ArticleContent;
use function Sodium\compare;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Request;

class ArticleController extends Controller
{
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
            ]
        ];
    }

    /**
     * 展示文章列表
     * @return string
     */
    public function actionIndex()
    {
        //获取数据
        $query=Article::find();
        //计算数的总条据数  每一页显示的条数   当前页
        $count=$query->count();
        //c创建每一页的对象
        $page=new Pagination([
            'pageSize' => 3,//每页显示条数
            'totalCount' => $count,//总条数
        ]);
        //创建一个model对象
        $articles=$query->offset($page->offset)->limit($page->limit)->all();
        //引入视图
        return $this->render('index',compact('articles','page'));

    }

    /**
     * 文章添加
     * @return string
     *
     */
    public function actionAdd()
    {
        //创建一个model对象
        $model=new Article();
        //创建一个文章内容对象
        $content=new ArticleContent();
        //创建一个得到所有分类的对象
        $cates=ArticleCate::find()->asArray()->all();
        //把二维数组转换成一维数组
        $cateArr=ArrayHelper::map($cates,'id','cate_name');
        //创建一个requerst对象
        $request=new Request();
        //创建post传值
        if ($request->isPost) {
            //绑定数据
            $model->load($request->post());
//            var_dump($app);exit;
            //后台验证
            if ($model->validate()) {
                //保存数据
                if ($model->save()) {
                    //保存文章内容
                    $content->load($request->post());
//                    var_dump($add);exit;
                    //添加文章ID
                    $content->article_id=$model->id;
//                  var_dump($content->article_id);exit;
                    //保存数据
                    if ($content->save()) {
                        //提示信息
                        \Yii::$app->session->setFlash('success','恭喜你！添加成功');
                        //跳转页面
                        return $this->redirect(['index']);
                    }

                }
            }else{
                //打印错误
                var_dump($model->getErrors());exit;
            }

        }
        //引入视图
        return $this->render('add',compact('model','content','cateArr'));


    }

    /**
     * 文章编辑
     * @return string
     *
     */
    public function actionEdit($id)
    {
        //创建一个model对象
        $model=Article::findOne($id);
        //创建一个文章内容对象
        $content=ArticleContent::findOne(['article_id'=>$id]);
        //创建一个得到所有分类的对象
        $cates=ArticleCate::find()->asArray()->all();
        //把二维数组转换成一维数组
        $cateArr=ArrayHelper::map($cates,'id','cate_name');
        //创建一个requerst对象
        $request=new Request();
        //创建post传值
        if ($request->isPost) {
            //绑定数据
            $model->load($request->post());
//            var_dump($app);exit;
            //后台验证
            if ($model->validate()) {
                //保存数据
                if ($model->save()) {
                    //保存文章内容
//                    $content->load($request->post());
//                    var_dump($add);exit;
                    //添加文章ID
                    $content->article_id=$model->id;
//                  var_dump($content->article_id);exit;
                    //保存数据
                    if ($content->save()) {
                        //提示信息
                        \Yii::$app->session->setFlash('success','恭喜你！编辑成功');
                        //跳转页面
                        return $this->redirect(['index']);
                    }

                }
            }else{
                //打印错误
                var_dump($model->getErrors());exit;
            }

        }
        //引入视图
        return $this->render('add',compact('model','content','cateArr'));


    }



    /**
     * 删除分类列表
     * @param $id 分类ID
     * @return \yii\web\Response
     */
    public function actionDel($id)
    {
        //删除数据
        if (Article::findOne($id)->delete() && ArticleContent::findOne(['article_id'=>$id])->delete()) {
            //提示信息
            \Yii::$app->session->setFlash('danger','恭喜你！删除成功');
            //跳转页面
            return $this->redirect(['index']);

        }

    }

}