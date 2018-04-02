<?php

use yii\db\Migration;

/**
 * Handles the creation of table `admin`.
 */
class m180320_111804_create_admin_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('admin', [
            'id' => $this->primaryKey(),
            'username'=>$this->string(50)->notNull()->comment('用户名'),
            'password'=>$this->string(32)->notNull()->comment('密码'),
            'salt'=>$this->string()->notNull()->comment('盐'),
            'email'=>$this->string(30)->notNull()->comment('邮箱'),
            'token'=>$this->string(30)->notNull()->comment('自动登录令牌'),
            'token_create_time'=>$this->integer()->comment('令牌创建时间'),
            'add_time'=>$this->integer()->comment('注册时间'),
            'last_time'=>$this->integer()->comment('最后登录时间'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('admin');
    }
}
