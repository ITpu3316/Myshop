
<a href='<?=\yii\helpers\Url::to(['add'])?>' class="btn btn-info">添加</a>
<table class="table">
    <tr>
        <td>ID</td>
        <td>图书名称</td>
        <td>价格</td>
        <td>图书编号</td>
        <td>上架时间</td>
        <td>是否上架</td>
        <td>图书简介</td>
        <td>图像</td>
        <td>作者</td>
        <td>操作</td>
    </tr>
    <?php foreach ($books as $book):?>
    <tr>
        <td><?=$book->id?></td>
        <td><?=$book->name?></td>
        <td><?=$book->money?></td>
        <td><?=$book->sn?></td>
        <td><?=date("Ymd H:i:s",$book->create_time)?></td>
        <td><?=\frontend\models\Book::$isget[$book->isget]?></td>
        <td><?=$book->detail?></td>
        <td><img src="/<?=$book->logo?>" height="50"></td>
        <td><?=$book->content->author?></td>
        <td>
            <a href="<?=\yii\helpers\Url::to(['edit','id'=>$book->id])?>" class="btn btn-success">编辑</a>
            <a href="<?=\yii\helpers\Url::to(['del','id'=>$book->id])?>" class="btn btn-danger">删除</a>
        </td>
    </tr>
<?php endforeach;?>
</table>

<?=\yii\widgets\LinkPager::widget([
    'pagination' => $page,

])?>

