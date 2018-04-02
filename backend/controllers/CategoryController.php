<?php

namespace backend\controllers;

use backend\models\Category;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\helpers\Json;
use yii\web\Request;

class CategoryController extends \yii\web\Controller
{
    /**
     * 显示商品分类数据
     * @return string
     */
    public function actionIndex()
    {
        //获取所有的数据
        $categorys=Category::find()->orderBy('tree,lft')->all();
        //载入视图
        return $this->render('index',compact('categorys'));
    }

    /**
     * 添加商品分类(树形结构)
     *
     * @return string|\yii\web\Response
     */
    public function actionAdd(){
        //获取你所有的数据
        $cate=new Category();

        //查询所有的分类数据
        $cates=Category::find()->asArray()->all();
        //伪造一个一级分类数据 的数据
        $cates[]=['id'=>0,'name'=>'一级分类','parent_id'=>0];

        //转换成json对象
        $cateJson=Json::encode($cates);

//        var_dump($cateJson);exit();
        //判断post传值
        $request=new Request();
        if ($request->isPost) {
            //数据绑定
            $cate->load($request->post());
            //后台验证
            if ($cate->validate()) {
                //判断parent_id=0时,添加一级分类
                if ($cate->parent_id==0) {
                    //创建一个一级分类
                    $cate->makeRoot();
                    //提示信息
                    \Yii::$app->session->setFlash('success','恭喜你'.$cate->name.'!添加一级分类成功');
                    //刷新页面
                    return $this->redirect(['index']);

                }else{
                    //添加一个子分类
                    //找到一个父级分类对象
                    $cateParent=Category::findOne($cate->parent_id);
                    //把新的分类添加到父级中
                    $cate->prependTo($cateParent);
                    //提示信息
                    \Yii::$app->session->setFlash('success',"恭喜你!创建{$cateParent->name}分类的子分类:".$cate->name." 成功");
                    //刷新页面
                    return $this->redirect(['index']);
                }
            }else{
                //TODO：打印错误
                var_dump($cate->getErrors());
            }


        }
        //载入视图
        return $this->render('add',compact('cate','cateJson'));

    }


    /**
     * 商品分类删除
     * @param $id
     */
    public function actionDel($id){
        if (Category::findOne($id)->deleteWithChildren()) {
            return $this->redirect(['index']);
        }


    }


    /**
     * 编辑商品分类
     * @param $id 商品ID
     * @return string|\yii\web\Response
     *
     */
    public function actionEdit($id){
        //获取你所有的数据
        $cate=Category::findOne($id);

        //查询所有的分类数据
        $cates=Category::find()->asArray()->all();
        //伪造一个一级分类数据 的数据
        $cates[]=['id'=>0,'name'=>'一级分类','parent_id'=>0];

        //转换成json对象
        $cateJson=Json::encode($cates);

//        var_dump($cateJson);exit();
        //判断post传值
        $request=new Request();
        if ($request->isPost) {
            //数据绑定
            $cate->load($request->post());
            //后台验证
            if ($cate->validate()) {

                //捕获异常状态
                try{
                    //判断parent_id=0时,添加一级分类
                    if ($cate->parent_id==0) {
                        //创建一个一级分类
                        $cate->save();
                        //提示信息
                        \Yii::$app->session->setFlash('success','恭喜修改一级分类成功');

                    }else{
                        //添加一个子分类
                        //找到一个父级分类对象
                        $cateParent=Category::findOne($cate->parent_id);
                        //把新的分类添加到父级中
                        $cate->prependTo($cateParent);
                        //提示信息
                        \Yii::$app->session->setFlash('success',"恭喜你!修改{$cateParent->name}分类成功");

                    }
                    //刷新页面
                    return $this->redirect(['index']);
                }
                catch (Exception $exception){
                    \Yii::$app->session->setFlash("danger","不能移动节点到你的子孙节点中");
                }

            }else{
                //TODO：打印错误
                var_dump($cate->getErrors());
            }


        }
        //载入视图
        return $this->render('add',compact('cate','cateJson'));

    }

    /**
     * 调试树形结构分类
     */
    public function actionTest(){
        //创建一个一级分类
//        $cate=new Category();
//        $cate->name="电脑";
//        //创建一个一级分类
//        $cate->makeRoot();
        //添加一个子分类
        //找到一个父级分类对象
        $cateParent=Category::findOne(1);
        //创建一个新的 分类
        $cate=new Category();
        $cate->name="电视";
        $cate->parent_id=1;
        //把新的分类添加到父级中
        $cate->prependTo($cateParent);
        var_dump($cate->errors);

    }

}
