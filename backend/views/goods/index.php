<?php
/* @var $this yii\web\View */
?>
<h1>商品列表展示</h1>

<form class="form-inline pull-right">
    <select class="form-control" name="status">
        <option>请选择..</option>
        <option value="0" <?=Yii::$app->request->get('status')==="0"?"selected":""?>>上架</option>
        <option value="1"  <?=Yii::$app->request->get('status')==="1"?"selected":""?>>下架</option>
    </select>
    <div class="form-group">
        <input type="text" class="form-control" id="minPrice" placeholder="最低价" name="minPrice" size="5" value="<?=Yii::$app->request->get('minPrice')?>">
    </div>
    <div class="form-group">
        -
        <input type="text" class="form-control" id="maxPrice" placeholder="最高价" name="maxPrice" size="5" value="<?=Yii::$app->request->get('maxPrice')?>">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" id="keyword" placeholder="名称或货号" name="keyword" size="10" value="<?=Yii::$app->request->get('keyword')?>">
    </div>
    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
</form>
<a href='<?=\yii\helpers\Url::to(['add'])?>' class="btn btn-info glyphicon glyphicon-plus"></a>
<table class="table">
    <tr>
        <td>商品ID</td>
        <td>商品名称</td>
        <td>商品货号</td>
        <td>商品LOGO</td>
        <td>商品分类ID</td>
        <td>品牌ID</td>
        <td>市场价格</td>
        <td>本店价格</td>
        <td>库存</td>
        <td>状态</td>
        <td>排序</td>
        <td>录入时间</td>
        <td>操作</td>
    </tr>
    <?php foreach ($goods as $good):?>
        <tr>
            <td><?=$good->id?></td>
            <td><?=$good->name?></td>
            <td><?=$good->sn?></td>
            <td><img src="<?=$good->logo?>" height="50"></td>
            <td><?=$good->categorys->name?></td>
            <td><?=$good->brands->name?></td>
            <td><?=$good->market_price?></td>
            <td><?=$good->shop_price?></td>
            <td><?=$good->stock?></td>
            <td><?=\backend\models\Goods::$ses[$good->status]?></td>
            <td><?=$good->sort?></td>
            <td><?=date("Y-m-d H:i:s",$good->create_time)?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['edit','id'=>$good->id])?>" class="btn btn-success glyphicon glyphicon-pencil" ></a>
                <a href="<?=\yii\helpers\Url::to(['del','id'=>$good->id])?>" class="btn btn-danger glyphicon glyphicon-trash"></a>
            </td>
        </tr>
    <?php endforeach;?>
</table>

<?=\yii\widgets\LinkPager::widget(['pagination' => $page])?>
