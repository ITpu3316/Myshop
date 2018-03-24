<?php
/* @var $this yii\web\View */
?>
<h1>文章列表</h1>
<a href='<?=\yii\helpers\Url::to(['add'])?>' class="btn btn-info glyphicon glyphicon-plus"></a>
<table class="table">
    <tr>
        <td>名称</td>
        <td>描述</td>
        <td>操作</td>
    </tr>
    <?php foreach ($items as $item):?>
        <tr>
            <td><?=strpos($item->name,'/')!==false?"----":""?><?=$item->name?></td>
            <td><?=$item->description?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['edit','name'=>$item->name])?>" class="btn btn-success glyphicon glyphicon-pencil"></a>
                <a href="<?=\yii\helpers\Url::to(['del','name'=>$item->name])?>" class="btn btn-danger glyphicon glyphicon-trash"></a>
            </td>
        </tr>
    <?php endforeach;?>
</table>


