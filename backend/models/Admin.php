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
    //声明一个属性来保存所有的权限名称
    public $adminRole;
    //设置一个时间方法
        public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['add_time','last_time'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['last_time'],
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
        $scenarios['add'] = ['username', 'password','status','adminRole'];
        $scenarios['edit'] = ['username', 'status', 'password','adminRole'];
        return $scenarios;
    }
    public static $sta=['0'=>'禁用','1'=>'激活'];

    /**
     * @inheritdoc
     * ,'on' => ['create', 'update']
     * , 'on' => 'create'
     */
    public function rules()
    {
        return [
            [['username','status'], 'required'], //在add或edit中都要输入
            [['password'], 'required','on' => 'add'],//在add中的场景
            [['password'], 'safe','on' => 'edit'],//在edit中的场景
            [['add_time', 'last_time','adminRole'], 'safe'],
            [['username'],'unique'],
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
            'status' => '状态',
            'adminRole'=>'角色',
            'ip' => 'ip',
            'token' => '自动登录令牌',
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
        return Admin::findOne(['id'=>$id,'status'=>1]);
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
        return $this->token;
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
        // TODO: 获取令牌

        return $this->token ===$authKey;
    }
}
