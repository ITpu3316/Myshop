<?php

namespace frontend\controllers;

use frontend\models\Address;
use yii\helpers\Json;
use yii\web\Request;

class AddressController extends \yii\web\Controller
{
//    public $enableCsrfValidation=false;
    public function actionIndex()
    {
        //获取所有的数据
        $addre=Address::find()->where(['user_id'=>\Yii::$app->user->id])->all();
        return $this->render('index',compact('addre'));
    }

    /**
     * 添加地址
     * @return string
     */
    public function actionAdd()
    {
        //实例化
        $address=new Address();
        //判断post提交
        $reques=new Request();
        if ($reques->isPost) {
            //绑定数据
            $address->load($reques->post());
            //后台验证
            if ($address->validate()) {
                //给user_id赋值
                $address->user_id=\Yii::$app->user->id;
                //判断状态
                if ($address->status===null) {
                    $address->status=0;
                }else{
                    //从新设置其他的地址的状态
                    Address::updateAll(['status'=>0],['user_id'=>$address->user_id]);

                    $address->status=1;
                }
                //保存数据
                if ($address->save()) {
                    $result=[
                        'status'=>1,
                        'msg'=>'添加成功',
                    ];
                    return Json::encode($result);

                }

            }else{
                //打印错误
                $result=[
                    'status'=>0,
                    'msg'=>'添加失败',
                    'data'=>$address->getErrors(),
                ];
                return Json::encode($result);
            }
        }
    }

    /**
     * 地址删除
     * @param $id 收货人ID
     * @return \yii\web\Response
     */
    public function actionDel($id)
    {
        if (Address::findOne(['id'=>$id,'user_id'=>\Yii::$app->user->id])->delete()) {
            $result=[
                'status'=>1,
                'msg'=>'删除成功',
            ];
            return Json::encode($result);
        }

    }

    /**
     * 设置默认地址
     * @param $id 用户ID
     * @return \yii\web\Response
     */
    public function actionDefault($id){
        $address =  Address::findOne(['id'=>$id,'user_id'=>\Yii::$app->user->id]);
//        echo "<pre>";
//        var_dump($address);exit();
        if ($address->status===1) {
            $address->status=0;
            $address->save();
            return $this->refresh();
        }else{
            //从新设置其他的地址的状态
            Address::updateAll(['status'=>0],['user_id'=>$address->user_id]);
            $address->status=1;
            $address->save();
            return $this->refresh();
        }

    }

}
