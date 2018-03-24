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
    public $rememberMe =true;

    private $_user;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['rememberMe'],'safe']
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