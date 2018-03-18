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



