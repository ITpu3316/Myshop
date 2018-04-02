<Himl><h1>文章分类列表</h1></Himl><br>
<a href='<?=\yii\helpers\Url::to(['add'])?>' class="btn btn-info glyphicon glyphicon-plus
"></a>
<table class="table">
    <tr>
        <td>ID</td>
        <td>分类名称</td>
        <td>操作</td>
    </tr>
    <?php foreach ($cates as $cate):?>
        <tr>
            <td><?=$cate->id?></td>
            <td><?=$cate->cate_name?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['edit','id'=>$cate->id])?>" class="btn btn-success glyphicon glyphicon-pencil"></a>
                <a href="<?=\yii\helpers\Url::to(['del','id'=>$cate->id])?>" class="btn btn-danger glyphicon glyphicon-trash"></a>
            </td>
        </tr>
    <?php endforeach;?>
</table>


