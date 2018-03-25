# 1.项目介绍
## 1.1.项目描述简介

```
类似京东商城的B2C商城 (C2C B2B O2O P2P ERP进销存 CRM客户关系管理)
电商或电商类型的服务在目前来看依旧是非常常用，虽然纯电商的创业已经不太容易，但是各个公司都有变现的需要，所以在自身应用中嵌入电商功能是非常普遍的做法。
为了让大家掌握企业开发特点，以及解决问题的能力，我们开发一个电商项目，项目会涉及非常有代表性的功能。
为了让大家掌握公司协同开发要点，我们使用git管理代码。
在项目中会使用很多前面的知识，比如架构、维护等等。
```

## 1.3.开发环境和技术

header 1 | header 2
---|---
开发环境 | Window
开发工具 | Phpstorm+PHP7.0+GIT+Apache
相关技术 | Yii2.0+CDN+jQuery+sphinx

## 1.4.项目人员组成周期成本
### 1.4.1.人员组成
- 职位          	|   人数      |	    备注
- 项目经理和组长	|      1      |	一般小公司由项目经理负责管理，中大型公司项目由项目经理或组长负责管理
- 后台开发人员	    |    2-3	
- UI设计人员	    |     0	
- 前端开发人员	    |            1	专业前端不是必须的，所以前端开发和UI设计人员可以同一个人
- 测试人员	        |     1	有些公司并未有专门的测试人员，测试人员可能由开发人员完成测试。

```
公司有测试部，测试部负责所有项目的测试。

项目测试由产品经理进行业务测试。

项目中如果有测试，一般都具有Bug管理工具。（介绍某一个款，每个公司Bug管理工具不一样）
```

### 1.4.2.项目周期成本
- 人数	周期	备注
- 1	两周需求及设计	项目经理 
- 
- 
- 1	两周
- UI设计	UI/UE
- 4（1测试  2后端  1前端）	3个月
- 第1周需求设计
- 4-8周时间完成编码
- 1-2周时间进行测试和修复	
- 
- 开发人员、测试人员
## 2.系统功能模块
### 2.1.需求
品牌管理：
商品分类管理：
商品管理：
账号管理：
权限管理：
菜单管理：
订单管理：

### 2.2.流程
自动登录流程
购物车流程
订单流程
### 2.3.设计要点（数据库和页面交互）
系统前后台设计：前台www.yiishop.com 后台admin.yiishop.com 对url地址美化
商品无限级分类设计：
购物车设计

### 2.4.要点难点及解决方案

##### 先自己找出错误所在在进行百度
##### 不行在然后问老师



## 3.品牌功能模块
### 3.1.需求
品牌管理功能涉及品牌的列表展示、品牌添加、修改、删除功能。
品牌需要保存缩略图和简介。
品牌删除使用逻辑删除。 
### 3.2.流程

### 3.3.设计要点（数据库和页面交互）

### 3.4.要点难点及解决方案
- 1.删除使用逻辑删除,只改变status属性,不删除记录
- 2.使用webuploader插件,提升用户体验
- 3.使用composer下载和安装webuploader
- 4.composer安装插件报错,解决办法:
- composer global require "fxp/composer-asset-plugin:^1.2.0"
- 5.注册七牛云账号
## 4.文章管理模块
### 4.1.需求
文章的增删改查
文章分类的增删改查
### 4.2.设计要点
文章模型和文章详情模型建立1对1关系
### 4.3.要点难点及解决方案
1. 1.文章分类不能重复,通过添加验证规则unique解决
1. 2.文章垂直分表,创建表单使用文章模型和文章详情模型
1. 
## 5.常见面试问题


```
- ① 你介绍下这个项目吧？
- ② 项目中有什么难点么？你如何解决的？
- ③ 请描述下你角色权限体系是如何设计与实现的？
- ④ 如果知道某用户的用户名，如何防止恶意用户暴力破解用户的密码？
- ⑤ 你的购物流程是如何设计的？？
- ⑥ 如何避免短信被恶意刷取？
- ⑦ 大型网站优化的具体解决方案
- ⑧ GET POST的区别
- ⑨ COOKIE SESSION的区别
```

## 一:==第一天==
### 商品品牌实现

```
分析所需要求建立对应的数据表
在输入命名yii进行数据迁移
如图:品牌数据表(brand)
	id
	name(品牌名称)
	intro(简介)
	logo（品牌头像）
	sort(排序)
	status（状态）
建立对应的数据模型
<?php

namespace backend\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "admin".
 *
 * @property int $id
 * @property string $name
 * @property int $password
 * @property int $sex 性别
 * @property int $image 图片
 */
class Brand extends ActiveRecord
{

    public static $sexs=[1=>'上架',2=>'下架'];
    /**
     * @inheritdoc
     */
    //设置一个默认的属性
    public function rules()
    {
        return [
            [['name', 'sort','status','intro','logo'], 'required'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '品牌名称',
            'logo' => '品牌头像',
            'sort' => '品牌排序',
            'status' => '品牌状态',
            'intro'=>'品牌简介'
        ];
    }
}


建立对应的controller
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
//        var_dump($_FILES['file']);exit;
        $ak = 'g55WlYZmAcfjlQDw4CgilVkj-JiDkt6I7RtcPQM9';//七牛ID
        $sk = '2XVES6fEUq2aK14htnOjSVf-7cOFd-2RHfknBjcy';//七牛密钥
        $domain = 'http://p5obj1i27.bkt.clouddn.com/';//存储对象
        $bucket = 'php1108';//空间名称
        $zone = 'south_china';//时区
        //创建一个七牛云对象
        $qiniu = new Qiniu($ak, $sk,$domain, $bucket,$zone);
        $key = time();
        //拼接路径
        $key =$key. strtolower(strrchr($_FILES['file']['name'], '.'));
        //利用七牛云上传对象
        $qiniu->uploadFile($_FILES['file']['tmp_name'],$key);
        $url = $qiniu->getLink($key);
        $result=[
            'code'=>0,
            'url'=>$url,//预览地址
            'attachment'=>$url,//文件上传后的地址

        ];
        //返回json对象
        return Json::encode($result);
    }

}
然后实现对应数据的CURD

```

## 第二天
### 文章分类

```
 分析所得的数据
 文章分类数据表(article_cate)
	id
	cate_name(分类名称)
然后建立起对应的数据迁移

再次建立起对应数据模型

<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article_cate".
 *
 * @property int $id
 * @property string $cate_name 文章分类
 */
class ArticleCate extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cate_name'], 'required'],
            [['cate_name'],'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cate_name' => '文章分类',
        ];
    }
}
建立起对应的controller
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
以上实现起对应的CURD


```

## 文章
### 分析需求所得的数据

```
文章数据表(article)
	id
	name（文章主题）
	cate_id（分类ID）
	intro(简介)
	status(状态)
	sort(排序)
	create_time（录入时间）
	upload_time(修改时间)


```

### 建立索取的数据模型

```
<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $name 文章主题
 * @property int $cate_id 分类id
 * @property string $intro 简介
 * @property int $status 状态
 * @property int $sort 排序
 * @property int $create_time 录入时间
 * @property int $upload_time 修改时间
 */
class Article extends \yii\db\ActiveRecord
{
    //设置一个时间方法
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['create_time', 'upload_time'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['upload_time'],
                ],
                // if you're using datetime instead of UNIX timestamp:
                // 'value' => new Expression('NOW()'),
            ],
        ];
    }
    public static $status;
    public $detail;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sort', 'name', 'intro','sort'], 'required'],
            [['cate_id','status'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '文章主题',
            'cate_id' => '分类id',
            'intro' => '简介',
            'status' => '状态',
            'sort' => '排序',
            'create_time' => '录入时间',
            'upload_time' => '修改时间',
            'detail'=>'文章内容'
        ];
    }

    /**
     * 一对一
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(ArticleCate::className(),['id'=>'cate_id']);

    }

//    public function getContents()
//    {
//        return $this->hasOne(ArticleContent::className(),['article_id'=>'id']);
//
//    }
}
然后建立起controller
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
            'pageSize' => 2,//每页显示条数
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
        if ($article=Article::findOne($id)->delete()) {
            //提示信息
            \Yii::$app->session->setFlash('danger','恭喜你！删除成功');
            //跳转页面
            return $this->redirect(['index']);

        }

    }


    /**
     * 按照一条ID获取数据
     * @param $id 文章ID
     * @return string
     */
//    public function actionContentList($id)
//    {
//        //获取一条数据
//        $contents=ArticleContent::findOne($id);
//        //传递数据
//        return $this->render('index',compact('contents'));
//
//
//    }

}

```

## 文章内容
### 分析所需要求建立起对应的

```
文章内容数据表(article_content)
	id
	detail（内容）
	article_id（文章ID）
```
### 然后建立起对应的数据模型

```
<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article_content".
 *
 * @property int $id
 * @property string $detail 文章内容
 * @property int $article_id 文章ID
 */
class ArticleContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['detail'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function at5tributeLabels()
    {
        return [
            'id' => 'ID',
            'detail' => '文章内容',
            'article_id' => '文章ID',
        ];
    }
}

```
## 分析所需数据建立controller

```
在这里内容不需要CURD
只需在文章中显示
```
# 6.商品管理模块
## 6.1.需求
1. 保存每天创建多少商品,创建商品的时候,更新当天创建商品数量
### 分析所得的数据结构

```
商品分类(category)
	id(商品)
	树型(tree)
	左值(left)
	右值(right)
	商品名称(name)
	父级ID(parent_id)
	简介(intro)
	深度(depath)
```

1. 商品增删改查
### 在模型中

```
<?php

namespace backend\models;

use backend\components\MenuQuery;
use creocoder\nestedsets\NestedSetsBehavior;
use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property int $tree
 * @property int $lft
 * @property int $rgt
 * @property int $depth 深度
 * @property string $name 分类名称
 * @property string $intro 简介
 * @property int $parent_id 父类ID
 */
class Category extends \yii\db\ActiveRecord
{
    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                'treeAttribute' => 'tree',
                'leftAttribute' => 'lft',
                'rightAttribute' => 'rgt',
                'depthAttribute' => 'depth',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new MenuQuery(get_called_class());
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'name','parent_id'], 'required'],
            [['intro'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '商品ID',
            'depth' => '深度',
            'name' => '商品名称',
            'intro' => '简介',
            'parent_id' => '父类ID',
        ];
    }
}

```
### 在controller中需要分析

```
<?php

namespace backend\controllers;

use backend\models\Category;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\web\Request;

class CategoryController extends \yii\web\Controller
{
    /**
     * 显示商品分类数据
     * @return string
     */
//    public function actionIndex()
//    {
//        //获取所有的数据
//        $categorys=Category::find()->all();
//        //载入视图
//        return $this->render('index',compact('categorys'));
//    }
    /**
     * 展示树形列表
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Category::find();
        $date = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);
        return $this->render('indexs',compact('date'));
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
                    return $this->refresh();

                }else{
                    //添加一个子分类
                    //找到一个父级分类对象
                    $cateParent=Category::findOne($cate->parent_id);
                    //把新的分类添加到父级中
                    $cate->prependTo($cateParent);
                    //提示信息
                    \Yii::$app->session->setFlash('success',"恭喜你!创建{$cateParent->name}分类的子分类:".$cate->name." 成功");
                    //刷新页面
                    return $this->refresh();
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
     * 删除
     * @param $id
     */
    public function actionDelete($id){
        $cate=Category::findOne($id);


    }


    /**
     * 编辑商品分类
     * @param $id 商品ID
     * @return string|\yii\web\Response
     *
     */
    public function actionUpdate($id)
    {
        //创建一个model对象
        $model=Category::findOne($id);
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
        return $this->render('update',compact('model'));


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

```
### 这里的删除或编辑在第四天进行详细的操作

### 视图中

```
views
  category
    add.php
    indexs.php
```
### add.php

```
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/18 0018
 * Time: 15:29
 */

$form=\yii\bootstrap\ActiveForm::begin();

echo $form->field($cate,'name');
echo $form->field($cate,'parent_id')->hiddenInput(['value'=>0]);
echo \liyuze\ztree\ZTree::widget([
    'setting' => '{
			data: {
				simpleData: {
					enable: true,
					pIdKey:"parent_id",
				} 
			},
			
			callback: {
				onClick: onClick,
			}
           
		}',
    'nodes' =>
        $cateJson,
]);
echo $form->field($cate,'intro')->textarea();
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);

\yii\bootstrap\ActiveForm::end();?>

<script>
	function onClick(e,treeId, treeNode) {
	    //找到父类ID
        $("#category-parent_id").val(treeNode.id);

        console.log(treeNode.id);
//        var zTree = $.fn.zTree.getZTreeObj("treeDemo");
//        zTree.expandNode(treeNode);
    }
</script>

<?php
//定义json代码快
$js=<<<EOF
    var treeObj=$.fn.zTree.getZTreeObj("w1");
    treeObj.expandAll(true);
EOF;
$this->registerJs($js);
?>

```
### indexs.php


```
<Himl><h1>商品分类列表</h1></Himl><br>
<a href='<?=\yii\helpers\Url::to(['add'])?>' class="glyphicon glyphicon-plus"></a>
<table class="table">
    <tr>
        <td>
            <?= \leandrogehlen\treegrid\TreeGrid::widget([
                'dataProvider' => $date,
                'keyColumnName' => 'id',
                'parentColumnName' => 'parent_id',
                'parentRootValue' => '0', //找到第一个父类的值
                'pluginOptions' => [
                    'initialState' => 'collapsed',
                ],
                'columns' => [
                    'name',
                    'id',
                    'parent_id',
                    'intro',
                    ['class' => 'yii\grid\ActionColumn']
                ]
            ]); ?>
        </td>
    </tr>

</table>


```

1. 商品列表页可以进行搜索(商品名,商品状态,售价范围 
1. 新增商品自动生成sn,规则为年月日+今天的第几个商品,比如201704010001 
1. 商品详情使用ueditor插件 

## 6.2.要点难点及解决方案
1. 商品分类只能选择第三级分类
1. 品牌使用下拉选择
1. 商品相册,添加完商品后,跳转到添加商品相册页面,允许多图片上传
1. 创建goods_day_count数据迁移时,如何创建date类型主键

## 5.商品介绍使用

```
UEditor(https://github.com/BigKuCha/yii2-ueditor-widget)
```
## 这里我们需要使用的一个插件

```
https://packagist.org/packages/leandrogehlen/yii2-treegrid
```
## 此时这个插件里有许多坑
### 今天解决的是:
    
```
修改编辑和删除时获取的商品ID不正确。
```

### 方法:
    
```
在文件yii\grid\ActionColumn配置文件:
protected function renderDataCellContent($model, $key, $index)
    {
    添加一句:
        $key=$model->id;//修改正确的Id
        ...
    }
```
# 6.商品管理模块
## 6.1.需求
### 1.保存每天创建多少商品,创建商品的时候,更新当天创建商品数量
### 需求建立对应关系

```
商品管理（goods）
	id
	商品名称(name)
	商品货号（sn）
	商品LOGO（goods_logo_id）
	商品详情图片（goods_print_id）
	商品分类id(goods_category_id)
	商品品牌（brand_id）
	商品详情（goods_intro_id）
	市场价格（market_price）
	本店价格（goods_price）
	状态（status）
	排序（sort）
	创建时间（create_time）
```

2.商品增删改查

```
## 商品
<?php

namespace backend\controllers;

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

    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
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


```

## 商品的模型中
- [x]
```
<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "goods".
 *
 * @property int $id
 * @property string $name 名称
 * @property string $sn 货号
 * @property int $logo 商品头像
 * @property int $goods_category_id 分类ID
 * @property int $brand_id 品牌ID
 * @property string $market_price 市场价格
 * @property string $shop_price 本地价格
 * @property int $stock 库存
 * @property int $status 是否上架
 * @property int $sort 排序
 * @property int $create_time 录入时间
 */
class Goods extends \yii\db\ActiveRecord
{
    //设置一个时间方法
    public function behaviors()
    {
        return [
            [

                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['create_time'],
                ],
                // if you're using datetime instead of UNIX timestamp:
                // 'value' => new Expression('NOW()'),
            ],
        ];
    }
    public static $ses=['0'=>'上架','1'=>'下架'];
    public $images;
//    public $detail;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','market_price', 'shop_price','stock','status' ], 'required'],
            [['goods_category_id','brand_id','sort','logo','images','sn'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'sn' => '货号',
            'logo' => '商品LOGO',
            'images' => '商品图片',
            'goods_category_id' => '所属分类',
            'brand_id' => '所属品牌',
            'market_price' => '市场价格',
            'shop_price' => '本地价格',
            'stock' => '库存',
            'status' => '是否上架',
            'sort' => '排序',
            'detail' => '商品详情',
        ];
    }

    /**
     * 获取数据此时
     * 一对一
     */
    public function getContents()
    {
        //获取数据
        return $this->hasOne(GoodsIntro::className(),['goods_id'=>'id']);

    }
    public function getCategorys()
    {
        //获取数据
        return $this->hasOne(Category::className(),["id"=>"goods_category_id"]);

    }
    public function getBrands()
    {
        //获取数据
        return $this->hasOne(Brand::className(),['id'=>'brand_id']);

    }

}

```
## 商品内容详情GoodsIntroController.php

```
<?php

namespace backend\controllers;

use backend\models\GoodsIntro;

class GoodsIntroController extends \yii\web\Controller
{
    /**
     * 展示商品详情
     * @return string
     *
     */
    public function actionIndex()
    {
        //获取所有的数据
        $intros=GoodsIntro::find()->all();
        //载入视图
        return $this->render('index',compact('intros'));
    }

}

```
## 商品内容模型

```
<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods_intro".
 *
 * @property int $id
 * @property int $goods_id 商品ID
 * @property string $content 商品描述
 */
class GoodsIntro extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => '商品ID',
            'content' => '商品描述',
        ];
    }
}

```
## 商品头像模型GoodsLogo.php

```
<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goods_logo".
 *
 * @property int $id
 * @property int $goods_id 商品ID
 * @property string $path 图片路径
 */
class GoodsLogo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => '商品ID',
            'path' => '图片路径',
        ];
    }
}

```
## 分析所需的商品内容详情

```
商品详情（goods_intro）
	id
	商品内容（intro）
	商品id(goods_id)
```
## 分析所需的商品LOGO

```
商品logo表（goods_logo）
	id
	商品id（goods_id）
	图片路径（path）
```




## 3.商品列表页可以进行搜索(商品名,商品状态,售价范围 

## 4.新增商品自动生成sn,规则为年月日+今天的第几个商品,比如201704010001 
## 5.商品详情使用ueditor插件 

# 6.2.要点难点及解决方案
### 1.商品分类只能选择第三级分类
#### 2.品牌使用下拉选择
#### 3.商品相册,添加完商品后,跳转到添加商品相册页面,允许多图片上传
#### 4.创建goods_day_count数据迁移时,如何创建date类型主键

5.商品介绍使用UEditor(https://github.com/BigKuCha/yii2-ueditor-widget)
 # 7.管理员模块
 ## 7.1.需求
 
 ```
 用户登录表(admin)
 	id
 	username(用户名)
 	password(密码)
 	salt(盐)
 	email(邮箱)
 	token(自动登录令牌)
 	token_create_time(令牌创建时间)
 	add_time(注册时间)
 	list_time(最后登录时间)
 ```
 ## 用户表所需的模型
 
 ```
 <?php
 
 namespace backend\models;
 
 use Yii;
 use yii\behaviors\TimestampBehavior;
 use yii\db\ActiveRecord;
 use yii\web\IdentityInterface;
 
 /**
  * This is the model class for table "admin".
  *
  * @property int $id
  * @property string $username 用户名
  * @property string $password 密码
  * @property string $salt 盐
  * @property string $email 邮箱
  * @property string $token 自动登录令牌
  * @property int $token_create_time 令牌创建时间
  * @property int $add_time 注册时间
  * @property int $last_time 最后登录时间
  */
 class Admin extends \yii\db\ActiveRecord implements IdentityInterface
 {
     //设置一个时间方法
     public function behaviors()
     {
         return [
             [
                 'class' => TimestampBehavior::className(),
                 'attributes' => [
                     ActiveRecord::EVENT_BEFORE_INSERT => ['add_time'],
                     ActiveRecord::EVENT_BEFORE_UPDATE => ['last_time'],
                 ],
                 // if you're using datetime instead of UNIX timestamp:
                 // 'value' => new Expression('NOW()'),
             ],
         ];
     }
     /**
      * @inheritdoc
      */
     public function rules()
     {
         return [
             [['username', 'password', 'email'], 'required'],
             [['add_time', 'last_time'], 'safe'],
         ];
     }
 
     /**
      * @inheritdoc
      */
     public function attributeLabels()
     {
         return [
             'id' => 'ID',
             'username' => '用户名',
             'password' => '密码',
             'salt' => '盐',
             'email' => '邮箱',
             'token' => '自动登录令牌',
             'token_create_time' => '令牌创建时间',
             'add_time' => '注册时间',
             'last_time' => '最后登录时间',
         ];
     }
 
     /**
      * Finds an identity by the given ID.
      * @param string|int $id the ID to be looked for
      * @return IdentityInterface the identity object that matches the given ID.
      * Null should be returned if such an identity cannot be found
      * or the identity is not in an active state (disabled, deleted, etc.)
      */
     public static function findIdentity($id)
     {
         return Admin::findOne($id);
     }
 
     /**
      * Finds an identity by the given token.
      * @param mixed $token the token to be looked for
      * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
      * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
      * @return IdentityInterface the identity object that matches the given token.
      * Null should be returned if such an identity cannot be found
      * or the identity is not in an active state (disabled, deleted, etc.)
      */
     public static function findIdentityByAccessToken($token, $type = null)
     {
         // TODO: Implement findIdentityByAccessToken() method.
     }
 
     /**
      * Returns an ID that can uniquely identify a user identity.
      * @return string|int an ID that uniquely identifies a user identity.
      */
     public function getId()
     {
         return $this->id;
     }
 
     /**
      * Returns a key that can be used to check the validity of a given identity ID.
      *
      * The key should be unique for each individual user, and should be persistent
      * so that it can be used to check the validity of the user identity.
      *
      * The space of such keys should be big enough to defeat potential identity attacks.
      *
      * This is required if [[User::enableAutoLogin]] is enabled.
      * @return string a key that is used to check the validity of a given identity ID.
      * @see validateAuthKey()
      */
     public function getAuthKey()
     {
         // TODO: Implement getAuthKey() method.
     }
 
     /**
      * Validates the given auth key.
      *
      * This is required if [[User::enableAutoLogin]] is enabled.
      * @param string $authKey the given auth key
      * @return bool whether the given auth key is valid.
      * @see getAuthKey()
      */
     public function validateAuthKey($authKey)
     {
         // TODO: Implement validateAuthKey() method.
     }
 }
 
 ```
 
 
 
 ## 1.管理员增删改查controller
 
 ```
 <?php
 
 namespace backend\controllers;
 
 use backend\models\Admin;
 use backend\models\LoginForm;
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
      *用户注册
      * @return string|\yii\web\Response
      *
      */
     public function actionAdd(){
         //建立model对象
         $model=new Admin();
         //建立requert对象
         $request=new Request();
         //判断是否是post传值
         if ($request->isPost) {
             //绑定数据
             $model->load($request->post());
             //后台验证
             if ($model->validate()) {
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
 
 
     /**
      * 退出登录
      * @return \yii\web\Response
      */
     public function actionOut(){
         \Yii::$app->user->logout();
 
         return $this->goHome();
 
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
             //通过用户名找到对应的数据
             $admin=Admin::find()->where(['username'=>$model->username])->one();
 //            var_dump($admin);exit();
             //验证用户名是不是存在
             if($admin){
 //                var_dump($admin);exit();
                 //用户名存在通过数据库找到对应的密码,验证密码
                 if($admin->password==$model->password){
 
 //                    var_dump($model->password);exit();
                     //通过设置的user组件来实现登录
                     \Yii::$app->user->login($admin);
 
 //                    var_dump( \Yii::$app->user->login($admin));exit();
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
 
         //载入视图
         return $this->render('login',compact('model'));
     }
 
 }
 
 ```
 ## 所需用户表单模型
 
 ```
 <?php
 /**
  * Created by PhpStorm.
  * User: Administrator
  * Date: 2018/3/13 0013
  * Time: 18:30
  */
 
 namespace backend\models;
 
 
 use yii\base\Model;
 
 class LoginForm extends Model
 {
     //设置属性
     public $username;
     public $password;
 
     public function rules()
     {
         return [
             [['username', 'password'], 'required'],
 //            [['code'],'captcha','captchaAction' => 'admin/code']//定义验证码的规则
         ];
     }
 
     /**
      * @inheritdoc
      */
     public function attributeLabels()
     {
         return [
             'username' => '用户名:',
             'password' => '密码:',
         ];
     }
 
 }
 ```
 
 
 ### 2.管理员登录和注销
 ### 3.自动登录(基于cookie)
 #### 4.促销管理(选做)
 #### 7.2.要点
 #### 1.创建admin表(在user表基础上添加最后登录时间和最后登录ip)
 
 ##场景的应用
```php
第一步:先在模型中设置一个场景
//定义一个场景
    public function scenarios()
    {
        //获取默认的场景
        $scenarios = parent::scenarios();
        //设置全新的场景
        $scenarios['add'] = ['username', 'password','status'];
        $scenarios['edit'] = ['username', 'status', 'password'];
        return $scenarios;
    }
第二步:在controller中的edit中
    //设置场景
    $model->setScenario('edit');
    //保存原来的密码
    $password=$model->password;
    //给密码加密
    $model->password=$model->password?\Yii::$app->security->generatePasswordHash($model->password):$password;
    同时不要忘记,设置密码不能显示
    $model->password=null;
    
    # 8.RBAC权限控制
    ## 8.1.需求
    ### 1.权限的增删改查
    
    ```
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
    
    ```
    
    ### 2.角色的增删改查
    
    ```
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
    }
    
    ```
    
    ### 3.角色和权限关联
    
    ```
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
           
            
    ```
    
    ### 4.用户和角色关联
    
    
    ```
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
    ```
    ```
    此时需要注意:
        在场景中需要添加上
        //定义一个场景
        public function scenarios()
        {
            //获取默认的场景
            $scenarios = parent::scenarios();
            //设置全新的场景
            $scenarios['add'] = ['username', 'password','status','adminRole'];
            $scenarios['edit'] = ['username', 'status', 'password','adminRole'];
            return $scenarios;
        }
    ```
    
    ### 5.菜单的增删改查
    
    ```
    
    ```
    
    ### 6.菜单和权限关联
    
    
    ```
    <?php
    
    namespace backend\models;
    
    use Yii;
    
    /**
     * This is the model class for table "mulu".
     *
     * @property int $id
     * @property string $name 名称
     * @property string $ico 样式
     * @property string $url 地址
     * @property int $parend_id 父类ID
     */
    class Mulu extends \yii\db\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [['id', 'name', 'ico', 'url', 'parend_id'], 'required'],
            ];
        }
    
        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'id' => 'ID',
                'name' => '名称',
                'ico' => '样式',
                'url' => '地址',
                'parend_id' => '父类ID',
            ];
        }
        //声明一个静态方法
        public static function menu(){
    //        $menu=[
    //            [
    //                'label' => '商品',
    //                'icon' => 'shopping-bag',
    //                'url' => '#',
    //                'items' => [
    //                    ['label' => '商品列表', 'icon' => 'bars', 'url' => ['/goods/index'],],
    //                    ['label' => '商品添加', 'icon' => 'cloud-download', 'url' => ['/goods/add'],],
    //                ],
    //            ],
    //        ];
            //定义一个空数组来存放新的菜单
            $menuAll=[];
            //得到所有的一级目录
            $mulus=self::find()->where(['parend_id'=>0])->all();
            foreach ( $mulus as $mu){
    
                $newMenu=[];
                $newMenu['label']=$mu->name;
                $newMenu['icon']=$mu->ico;
                $newMenu['url']=$mu->url;
    
                //通过当前一级目录找到所有的二级目录
                $muluSons=self::find()->where(['parend_id'=>$mu->id])->all();
    //            var_dump($muluSons);exit();
    
                //再次循环
                foreach ( $muluSons as $son) {
    
                    $newMenuSon = [];
                    $newMenuSon['label'] = $son->name;
                    $newMenuSon['icon'] = $son->ico;
                    $newMenuSon['url'] = $son->url;
    
    //                var_dump($newMenuSon);exit();
                    $newMenu['items'][]=$newMenuSon;
                }
    
    //            var_dump($newMenu);exit();
                $menuAll[]=$newMenu;
    
            }
    
            return $menuAll;
        }
    }
    
    ```
    
    ## 8.2.设计要点
    1.配置RBAC（在common配置authManager组件，执行rbac数据迁移）
    2.根据authManager相应方法进行开发

    
```
# 8.RBAC权限控制yii2 插件
## 8.1.需求
### 1.安装方法

```
在大象（https://packagist.org/packages/mdmsoft/yii2-admin）里找到mdmsoft/yii2-admin
```
### 下载

```
composer require mdmsoft/yii2-admin "~2.0"
```
### 这里的~需要到百度里去了解
## 配置文件

```
return [
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
            ...
        ]
        ...
    ],
```
### 菜单栏

```
yii migrate --migrationPath=@mdm/admin/migrations
```

### backend/config/main.php中

```
还行加上
'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        //白名单
        'allowActions' => [
//            '*',
            'admin/login',
            'admin/out',
//            'site/*',
//            'admin/*',
//            'some-controller/some-action',
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ]
    ]
```
### 这里额外提到
#### 时间输出

```
<span id="show"></span>
....
<script>
    window.onload = function() {
        var show = document.getElementById("show");
        setInterval(function() {
            var time = new Date();
            // 程序计时的月从0开始取值后+1
            var m = time.getMonth() + 1;
            var t = time.getFullYear() + "年" + m + "月"
                + time.getDate() + "日" + time.getHours() + ":"
                + time.getMinutes() + ":" + time.getSeconds();
            show.innerHTML = t;
        }, 1000);
    };
</script>
```
## 菜单栏图标显示

```
 <?php
                $callback = function($menu){
                    $data = json_decode($menu['data'], true);
                    $items = $menu['children'];
                    $return = [
                        'label' => $menu['name'],
                        'url' => [$menu['route']],
                    ];
                    //处理我们的配置
                    if ($data) {
                        //visible
                        isset($data['visible']) && $return['visible'] = $data['visible'];
                        //icon
                        isset($data['icon']) && $data['icon'] && $return['icon'] = $data['icon'];
                        //other attribute e.g. class...
                        $return['options'] = $data;
                    }
                    //没配置图标的显示默认图标
                    (!isset($return['icon']) || !$return['icon']) && $return['icon'] = 'fa fa-circle-o';
                    $items && $return['items'] = $items;
                    return $return;
                };
                ?>




        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => \mdm\admin\components\MenuHelper::getAssignedMenu(Yii::$app->user->id,null,$callback),
            ]
        ) ?>
```
## 菜单列表

```
更新菜单: 品牌
数据 
{"icon": " fa-bars", "visible": true}

```


