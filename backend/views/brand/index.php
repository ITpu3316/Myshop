<Himl><h1>品牌列表</h1></Himl><br>
<a href='<?=\yii\helpers\Url::to(['add'])?>' class="btn btn-info">添加</a>
<table class="table">
    <tr>
        <td>ID</td>
        <td>品牌名称</td>
        <td>品牌头像</td>
        <td>品牌排序</td>
        <td>品牌状态</td>
        <td>品牌简介</td>
        <td>操作</td>
    </tr>
    <?php foreach ($brands as $brand):?>
        <tr>
            <td><?=$brand->id?></td>
            <td><?=$brand->name?></td>
            <td><img src="/<?=$brand->logo?>" height="40"></td>
            <td><?=$brand->sort?></td>
            <td><?=\backend\models\Brand::$sexs[$brand->status]?></td>
            <td><?=$brand->intro?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['edit','id'=>$brand->id])?>" class="btn btn-success">编辑</a>
                <a href="<?=\yii\helpers\Url::to(['del','id'=>$brand->id])?>" class="btn btn-danger">删除</a>
            </td>
        </tr>
    <?php endforeach;?>
</table>

<?=\yii\widgets\LinkPager::widget(['pagination' => $page])?>
