<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_print`.
 */
class m180319_075234_create_goods_print_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('goods_print', [
            'id' => $this->primaryKey(),
            'goods_id'=>$this->integer()->comment('商品ID'),
            'path'=>$this->string()->comment('图片路径'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('goods_print');
    }
}
