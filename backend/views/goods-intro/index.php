<?php
/* @var $this yii\web\View */
?>
<h1>商品详情展示</h1>
<a href='<?=\yii\helpers\Url::to(['add'])?>' class="btn btn-info glyphicon glyphicon-plus"></a>
<table class="table">
    <tr>
        <td>ID</td>
        <td>商品ID</td>
        <td>商品详情</td>
        <td>操作</td>
    </tr>
    <?php foreach ($intros as $intro):?>
        <tr>
            <td><?=$intro->id?></td>
            <td><?=$intro->goods_id?></td>
            <td><?=$intro->content?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['edit','id'=>$intro->id])?>" class="btn btn-success glyphicon glyphicon-pencil"></a>
                <a href="<?=\yii\helpers\Url::to(['del','id'=>$intro->id])?>" class="btn btn-danger glyphicon glyphicon-trash"></a>
            </td>
        </tr>
    <?php endforeach;?>
</table>


