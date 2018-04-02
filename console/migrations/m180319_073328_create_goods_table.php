<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods`.
 */
class m180319_073328_create_goods_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('goods', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->comment('名称'),
            'sn' => $this->integer()->notNull()->comment('货号'),
            'logo' => $this->integer()->notNull()->comment('商品头像'),
            'goods_category_id' => $this->integer()->notNull()->comment('分类ID'),
            'brand_id' => $this->integer()->notNull()->comment('品牌ID'),
            'market_price' => $this->integer()->notNull()->comment('市场价格'),
            'shop_price' => $this->integer()->notNull()->comment('本地价格'),
            'stock' => $this->integer()->notNull()->comment('库存'),
            'status' => $this->integer()->notNull()->defaultValue(1)->comment('是否上架'),
            'sort' => $this->integer()->notNull()->defaultValue(20)->comment('排序'),
            'create_time'=>$this->integer()->notNull()->comment('录入时间')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('goods');
    }
}
