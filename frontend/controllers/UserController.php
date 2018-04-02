<?php

namespace frontend\controllers;

use backend\models\LoginForm;
use frontend\compontens\ShopCart;
use frontend\models\GoodsCart;
use frontend\models\User;
use Mrgoon\AliSms\AliSms;
use yii\helpers\Json;
use yii\web\Request;

class UserController extends \yii\web\Controller
{
    public function actions()
    {
        return [
            'code' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'maxLength' => 3,
                'minLength' => 3,
            ],
        ];
    }
//    public $layout=false;
//    public function actionIndex()
//    {
//        return $this->render(['index']);
//    }

    /**
     * 用户注册界面
     */
    public function actionReg(){
        $user=new User();
        //引入场景
        $user->setScenario('reg');
        //判断是不是post提交
        $request=\Yii::$app->request;
        if ($request->isPost) {
            //绑定数据
            $user->load($request->post());
            //后台验证
            if ($user->validate()) {
                //令牌
                $user->auth_key=\Yii::$app->security->generateRandomString();
                //哈希密码加密
                $user->password_hash=\Yii::$app->security->generatePasswordHash($user->password);

                //保存数据
                if ($user->save(false)) {
                    $result=[
                        'status'=>1,
                        'msg'=>'注册成功',
                        'data'=>"",
                    ];
                    //跳转页面
                    return Json::encode($result);
                }
            }else{
                $result=[
                    'status'=>0,
                    'msg'=>'注册失败',
                    'data'=>$user->errors,
                ];
                //跳转页面
                return Json::encode($result);
            }
//            var_dump($user);
            $user->username=$request->post('username');
            $user->email=$request->post('email');
            $user->mobile=$request->post('tel');
            $user->password_hash=\Yii::$app->security->generatePasswordHash($request->post('username'));

            $user->save();

        }

        //载入视图
        return $this->render('reg');
    }

    /**
     * 生成手机验证码
     * @param $mobile输入的手机号
     * @return int
     */
    public function actionSendSms($mobile){
        //生成验证码
        $code=rand(100000,999999);

        //发送验证码到$mobile

        $config = [
            'access_key' => 'LTAIG8veNdHfusVc',
            'access_secret' => 'K59adOn1qIh43BVjt1gcaAglsK5nHx',
            'sign_name' => '光木木',//签名
        ];

//        $aliSms = new Mrgoon\AliSms\AliSms();
        $aliSms=new AliSms();//创建一个发送短信的对象专门用来发送短信
        $response = $aliSms->sendSms($mobile, 'SMS_128646098', ['code'=> $code], $config);

        //        var_dump($response->Message);exit();
        if ($response->Message) {
            //把生成的验证码保存到session中 这里的手机号看做是键名，验证码是键值
            $session=\Yii::$app->session;

            $session->set('tel_'.$mobile,$code);

            //测试
            return $code;

        }else{

            var_dump($response->Message);
        }

    }

    /**
     * @param $mobile输入的手机号
     * @param $code生成的验证码
     */
    public function actionCheckSms($mobile,$code){
        //通过手机号取出之前存入的验证码
        $codeOld=\Yii::$app->session->get("tel_".$mobile);

        //判断输入的code是否准确
        if ($code==$codeOld) {
            echo "OK";
        }else{
            echo "NO";
        }
        
    }


    /**
     * 用户登录
     * @return string
     */
    public function actionLogin(){
        //实例化user
        $model=new User();
        //实例化request
        $request=new Request();
        //引入场景
        $model->setScenario('login');
        //判断是不是post提交
        if ($request->isPost) {
//            echo "<pre>";
            //保存数据
            $model->load($request->post());
            //后台验证
            if ($model->validate()) {
                //通过用户名找到对应的数据
                $users = User::find()->where(['username' => $model->username])->one();
//            var_dump($users);exit();
                //判断//用户存在则通过数据库找到对应的密码进行验证$users->passwprd_hash=$model->password_hash
                if ($users && \Yii::$app->security->validatePassword($model->password,$users->password_hash)) {
//                       获取用户登录最后的IP
                        $users->login_ip=ip2long(\Yii::$app->request->userIP);
//                        获取用户最后登录的时间
                        $users->login_time=time();
                        if ($users->save(false)) {
                            //通过设置的user组件来实现登录
                            \Yii::$app->user->login($users, $model->rememberMe ? 3600 * 24 : 0);
                            //同步cookie中的数据到数据库同时清空cookie
                            (new ShopCart())->dbSyn()->flush()->save();
//                            //取出cookie中的数据格式['商品ID'=>'商品数量']
//                            $cart=(new ShopCart())->get();
//                            //同步cookie中的数据到数据库中
//                            //得到当前的用户ID
//                            $userId=\Yii::$app->user->id;
//                            //循环遍历得到的数据
//                            foreach ($cart as $goodsId=>$goodsNum){
//                                //判断当前的用户商品信息是不是存在
//                                $cartDb=GoodsCart::find()->where(['goods_id'=>$goodsId,'user_id'=>$userId])->one();
//                                //判断
//                                if ($cartDb){
//                                    //+ 修改操作
//                                    $cartDb->goods_num+=$goodsNum;
//                                    // $cart->save();
//                                }else{
//                                    //创建对象
//                                    $cartDb=new GoodsCart();
//                                    //赋值
//                                    $cartDb->goods_id=$goodsId;
//                                    $cartDb->goods_num=$goodsNum;
//                                    $cartDb->user_id=$userId;
//                                }
//                                //保存
//                                $cartDb->save();
//                            }
                            //清空cookie中的数据

                            $results=[
                                'status'=>1,
                                'msg'=>'登录成功',
                                'data'=>"",
                            ];
                            //跳转页面
                            return Json::encode($results);
                        }
//
                }else{
//                    $model->addError('password','用户名或密码错误');

                    $results=[
                        'status'=>0,
                        'msg'=>'用户名或密码错误',
                        'data'=>$model->errors,
                    ];
                    //跳转页面
                    return Json::encode($results);
                }
//

            }else{
                $results=[
                    'status'=>0,
                    'msg'=>'登录失败',
                    'data'=>$model->errors,
                ];
                //跳转页面
                return Json::encode($results);
            }
//            var_dump($model->getErrors());exit();
        }
        //载入视图
        return $this->render('login');


    }

    /**
     * 用户退出
     * @return \yii\web\Response
     */
    public function actionLogout(){

        \Yii::$app->user->logout();

        return $this->redirect(['/index/index']);

    }

}
