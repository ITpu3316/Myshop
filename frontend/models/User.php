<?php

namespace frontend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username 用户名
 * @property string $auth_key 自动登录令牌
 * @property string $password_hash 哈希密码
 * @property string $password_reset_token
 * @property string $email 邮件
 * @property int $status 状态
 * @property int $created_at 注册时间
 * @property int $updated_at 修改时间
 * @property string $mobile 手机号码
 * @property int $logiin_time 最后登录时间
 * @property int $login_ip 登录IP
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $password;//密码
    public $rePassword;//确认密码
    public $checkCode;//注册验证码
    public $captcha;//短信验证码
    public $rememberMe;//是否记住密码
    public $checkde;//登录验证码
    //设置一个时间方法
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at','updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                // if you're using datetime instead of UNIX timestamp:
                // 'value' => new Expression('NOW()'),
            ],
        ];
    }
    //定义一个场景
    public function scenarios()
    {
        //获取默认的场景
        $scenarios = parent::scenarios();
        //设置全新的场景
        $scenarios['reg'] = ['username', 'password','rePassword','mobile','captcha','checkCode','email'];
        $scenarios['login'] = ['username','password','rememberMe ','checkCode'];
        return $scenarios;
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username','password','rePassword','mobile', 'email'], 'required'],
            [['username'],'unique','on' => 'reg'],
            [['mobile'],'match','pattern'=>'/(13|14|15|17|18|19)[0-9]{9}/','message'=>'请输入正确的手机号码'],//验证手机号码
            ['rePassword','compare','compareAttribute' => 'password'],//确认密码
            [['checkCode'],'captcha','captchaAction' => 'user/code'],//注册验证码
            [['captcha'],'validateCaptcha'],//自定义短信验证码规则
            [['rememberMe'],'safe','on' => 'login']//记住密码在login登录场景中
        ];
    }

    public function validateCaptcha($attribute){

        //通过手机号取出之前存入的验证码
        $codeOld=\Yii::$app->session->get("tel_".$this->mobile);

        //判断输入的code是否准确
        if ($this->captcha!=$codeOld) {
            $this->addError($attribute,'验证码错误');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'auth_key' => '自动登录令牌',
            'password' => '正确密码',
            'rePassword' => '再次输入密码',
            'password_reset_token' => 'Password Reset Token',
            'email' => '邮件',
            'status' => '状态',
            'created_at' => '注册时间',
            'updated_at' => '修改时间',
            'mobile' => '手机号码',
            'login_time' => '最后登录时间',
            'login_ip' => '登录IP',
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
        return User::findOne(['id'=>$id,'status'=>1]);
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
        return $this->auth_key;
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
        return $this->auth_key===$authKey;
    }
}
