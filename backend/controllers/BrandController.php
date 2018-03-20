<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/15 0015
 * Time: 17:06
 */

namespace backend\controllers;


use backend\models\Brand;
use yii\data\Pagination;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Request;
use yii\web\UploadedFile;
use crazyfd\qiniu\Qiniu;

class BrandController extends Controller
{
    /**
     * 品牌列表
     * @return string
     */
    public function actionIndex()
    {
        //获取数据
        $query=Brand::find()->where(['del'=>1]);
        //计算数的总条据数  每一页显示的条数   当前页
        $count=$query->count();
        //c创建每一页的对象
        $page=new Pagination([
            'pageSize' => 3,//每页显示条数
            'totalCount' => $count,//总条数
        ]);
        //创建一个model对象
        $brands=$query->offset($page->offset)->limit($page->limit)->all();
        //引入视图
        return $this->render('index',compact('brands','page'));

    }

    /**
     * 品牌添加
     * @return string|\yii\web\Response
     */
    public function actionAdd()
{
    //创建一个model对象
    $model=new Brand();
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
     * 品牌编辑
     * @param $id 品牌id
     * @return string|\yii\web\Response
     */
    public function actionEdit($id)
    {
        //创建一个model对象
        $model=Brand::findOne($id);
        //创建一个requerst对象
        $request=new Request();
        //创建post传值
        if ($request->isPost) {
            //得到上传图片对象
//            $model->img=UploadedFile::getInstance($model,'img');
//            var_dump($model->img);exit;
            //先定义一个空对象
//            $img="";
            //判断上传的对象是否为空
//            if ($model->img!==null) {
//                //然后定义上传文件的路径
//                $img="images/".time().".".$model->img->extension;
//                //把文件移动到backend/web/images下
//                $model->img->saveAs($img,false);
//            }
            //绑定数据
            $model->load($request->post());
            //后台验证
            if ($model->validate()) {
                //上传临时文件到数据库
//                $model->logo=$img?:$model->logo;
                //保存数据
                if ($model->save()) {
                    //提示信息
                    \Yii::$app->session->setFlash('success','恭喜你！编辑成功');
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
     * 品牌删除
     * @param $id 一个品牌ID
     * @return \yii\web\Response
     */
    public function actionDel($id)
    {
        Brand::updateAll(['del'=>0],['id'=>$id]);

        return $this->redirect(['index']);

    }

    /**
     * 品牌头像完善
     * @return string
     */
    public function actionUpload()
    {
//        var_dump($_FILES);
        //得到上传文件的对象
        $files=UploadedFile::getInstanceByName("file");
//        var_dump($files);
        if ($files!==null) {
            //获取路径
            $path="images/".time().".".$files->extension;
            //移动图片
            if ($files->saveAs($path,false)) {
                //{"code": 0, "url": "http://domain/图片地址", "attachment": "图片地址"}
                $result=[
                    'code'=>0,
                    'url'=>'/'.$path,//预览地址
                    'attachment'=>$path,//文件上传后的地址

                ];
                //返回json对象
                return Json::encode($result);
            }

        }else {
            //发生错误时
            $results = [
                'code' => 1,
                'msg' => "error",
            ];
            //返回一个json对象
            return Json::encode($results);
        }

    }

    /**
     * 品牌头像完善
     * @return string
     */
    public function actionQiniuUpload()
    {
      //var_dump($_FILES["file"]);exit();
        $ak = 'EAd29Qrh05q78_cZhajAWcbB1wYCBLyHLqkanjOG';  //应用id
        $sk = '_R5o3ZZpPJvz8bNGBWO9YWSaNbxIhpsedbiUtHjW';  //密钥
        $domain = 'http://p5nv0polm.bkt.clouddn.com/';   //上传图片地址
        $bucket = 'php1108';        //空间名称
        $zone = 'south_china';      //域名
        //创建七牛云对象
        $qiniu = new Qiniu($ak, $sk, $domain, $bucket, $zone);
        $key = uniqid();//放在同一时间内上传多张图片
        //拼路径
        $key .= strtolower(strrchr($_FILES['file']['name'], '.'));
        //利用七牛云上传图片
        $qiniu->uploadFile($_FILES['file']['tmp_name'], $key);
        $url = $qiniu->getLink($key);
//        var_dump($url);exit;
        $ok = [
            "code" => "0",
            "url" => $url,//在添加页面预览地址
            "attachment" => $url   //上传的图片地址
        ];
        return json_encode($ok);
    }

}