<?php

namespace backend\controllers;

use backend\filters\RbacFilter;
use backend\models\Brand;
use backend\models\Category;
use backend\models\Goods;
use backend\models\GoodsIntro;
use backend\models\GoodsLogo;
use backend\models\GoodsPrint;
use crazyfd\qiniu\Qiniu;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Request;
use yii\web\UploadedFile;

class GoodsController extends \yii\web\Controller
{
//    //注入行为
//    public function behaviors()
//    {
//        return [
//            'rbac'=>[
//                'class'=>RbacFilter::className()
//            ],
//
//        ];
//    }

    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
                    "imageUrlPrefix"  => "http://admin.myshop.com",//图片访问路径前缀
                ],
            ]
        ];
    }
    /**
     * 显示商品列表
     * @return string
     */
    public function actionIndex()
    {
        //获取数据
        $query=Goods::find();
        //创建一个用DB类来查询所有状态为上架和下架的数据
        $minPrice=\Yii::$app->request->get('minPrice');
        $maxPrice=\Yii::$app->request->get('maxPrice');
        $keyWord=\Yii::$app->request->get('keyword');
        $status=\Yii::$app->request->get('status');

        //查询最小值
        if($minPrice){
            $query->andWhere("shop_price>={$minPrice}");
        }

        //查询最大值
        if($maxPrice){
            $query->andWhere("shop_price<={$maxPrice}");
        }
        //查询货号或者商品名称
        if($keyWord !==""){
            $query->andWhere("name like '%{$keyWord}%' or sn like '%{$keyWord}%'");
        }

        /**
         * 查询判断商品状态 在这里说明Http协议传递的参数都是字符串
         * 因此这里的0或1要加双引号
         */
        if($status==="0" || $status==="1"){
            $query->andWhere(['status'=>$status]);

        }


        //计算数的总条据数  每一页显示的条数   当前页
        $count=$query->count();
        //c创建每一页的对象
        $page=new Pagination([
            'pageSize' => 3,//每页显示条数
            'totalCount' => $count,//总条数
        ]);
        //创建一个model对象
        $goods=$query->offset($page->offset)->limit($page->limit)->all();
        //引入视图
        return $this->render('index',compact('goods','page'));

    }

    /**
     * 商品添加
     * @return string|\yii\web\Response
     */
    public function actionAdd()
    {
        //创建一个model对象
        $model=new Goods();
        //创建一个所有Actrice商品分类数据的对象
        $cates=Category::find()->orderBy('tree,lft')->all();
        //把得到的数据二维数组转换成一维数组
        $cateArr=ArrayHelper::map($cates,'id','nameText');
        //创建一个所有brand商品品牌数据的对象
        $brands=Brand::find()->asArray()->all();
        $brandArr=ArrayHelper::map($brands,'id','name');

        //创建一个添加商品内容的对象
        $content=new GoodsIntro();

        //创建一个requerst对象
        $request=new Request();
        //创建post传值
        if ($request->isPost) {
            //绑定数据
            $model->load($request->post());
            //后台验证
            if ($model->validate()) {

//                var_dump($model->images);exit();
                //书写自动生成货号的对象
                //判断sn是不是有值
                if(!$model->sn){
                    //自动生成年月日
                    $dayTime=strtotime(date('Ymd'));//当前时间的时间戳
                    //找到当日添加的数据
                    $counts=Goods::find()->where(['>','create_time',$dayTime])->count();
                    //在编号的后面自动生成添加00001
                    $counts = $counts + 1;
                    $countStr="0000".$counts;
                    //获取后面的五位数
                    $countStr=substr($countStr,-5);

                    //把生成的时间戳放到货号中
                    $model->sn=date('Ymd').$countStr;

//                    var_dump($model->sn);exit();

                }

                //保存数据
                if ($model->save()) {
                    //保存文章内容
                    $content->load($request->post());
//                    var_dump($add);exit;
                    //添加文章ID
                    $content->goods_id=$model->id;

//                    var_dump($model->images);exit();
                    //多图操作
                    //循环遍历上传的图像
//                    var_dump($model->images);exit();
                    foreach ($model->images as $ima){
//                        var_dump($ima);exit();
                        //创建一个新的对象
                        $logo=new GoodsLogo();
                        //给对象的属性赋值
                        $logo->goods_id=$model->id;
                        $logo->path=$ima;
                        $logo->save();

                    }

                    //保存数据
                    if ($content->save()) {
//                        var_dump($model->images);exit();
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
        return $this->render('add',compact('model','cateArr','brandArr','content'));

    }
    /**
     * 商品编辑
     * @return string|\yii\web\Response
     */
    public function actionEdit($id)
    {
        //创建一个model对象
        $model=Goods::findOne(['id'=>$id]);
        //创建一个所有Actrice商品分类数据的对象
        $cates=Category::find()->orderBy('tree,lft')->all();
        //把得到的数据二维数组转换成一维数组
        $cateArr=ArrayHelper::map($cates,'id','nameText');
        //创建一个所有brand商品品牌数据的对象
        $brands=Brand::find()->asArray()->all();
        $brandArr=ArrayHelper::map($brands,'id','name');

        //创建一个添加商品内容的对象
        $content=GoodsIntro::findOne(['goods_id'=>$id]);

        //创建一个requerst对象
        $request=new Request();
        //创建post传值
        if ($request->isPost) {
            //绑定数据
            $model->load($request->post());
            //后台验证
            if ($model->validate()) {
//                var_dump($model->images);exit();
                //书写自动生成货号的对象
                //判断sn是不是有值
                if($model->sn!==null){
                    //自动生成年月日
                    $dayTime=strtotime(date('Ymd'));//当前时间的时间戳
                    //找到当日添加的数据
                    $counts=Goods::find()->where(['>','create_time',$dayTime])->count();
                    //在编号的后面自动生成添加00001
                    $counts+=1;
                    $countStr="0000".$counts;
                    //获取后面的五位数
                    $countStr=substr($countStr,-5);
                    //把生成的时间戳放到货号中
                    $model->sn=date('Ymd').$countStr;
//                    var_dump($model->sn);exit();
                }
                //保存数据
                if ($model->save()) {
                    //保存文章内容
                    $content->load($request->post());
                    //添加文章ID
                    $content->goods_id=$model->id;
                    //多图操作
                    //在编辑之前要把之前所有的图片删除
                    GoodsLogo::deleteAll(['goods_id'=>$id]);
                    //循环遍历上传的图像
//                    var_dump($model->images);exit();
                    foreach ($model->images as $ima){
//                        var_dump($ima);exit();
                        //创建一个新的对象
                        $logo=new GoodsLogo();
                        //给对象的属性赋值
                        $logo->goods_id=$model->id;
                        $logo->path=$ima;
                        $logo->save();
                    }
                    //保存数据
                    if ($content->save()) {
//                        var_dump($model->images);exit();
                        //提示信息
                        \Yii::$app->session->setFlash('success','恭喜你！修改成功');
                        //跳转页面
                        return $this->redirect(['index']);
                    }
                }
            }else{
                //打印错误
                var_dump($model->getErrors());exit;
            }
        }
        //从数据库获取数据图片信息
        $images=GoodsLogo::find()->where(['goods_id'=>$id])->asArray()->all();
        //var_dump($iamges);exit();
        //把二维数组转换成制定是一维数组
        $imag=array_column($images,'path');
//        var_dump($images);exit();
        //给属性赋值
        $model->images= $imag;

        //引入视图
        return $this->render('add',compact('model','cateArr','brandArr','content'));

    }


    /**
     * s删除商品数据
     * @param $id商品ID
     */
    public function actionDel($id){

        //删除数据
        if(Goods::findOne($id)->delete() && GoodsLogo::findOne(['goods_id'=>$id])->delete() && GoodsIntro::findOne(['goods_id'=>$id])->delete()){
            //提示信息
            \Yii::$app->session->setFlash('danger','删除成功');
            return $this->redirect(['index']);
        }

    }



}
