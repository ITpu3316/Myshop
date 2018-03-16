<Himl><h1>文章列表</h1></Himl><br>
<a href='<?=\yii\helpers\Url::to(['add'])?>' class="btn btn-info">添加</a>
<table class="table">
    <tr>
        <td>ID</td>
        <td>文章名称</td>
        <td>文章分类</td>
        <td>文章简介</td>
        <td>文章状态</td>
        <td>文章排序</td>
        <td>录入时间</td>
        <td>修改时间</td>
        <td>操作</td>
    </tr>
    <?php foreach ($articles as $article):?>
        <tr>
            <td><?=$article->id?></td>
            <td><?=$article->name?></td>
            <td><?=$article->content->cate_name?></td>
            <td><?=$article->intro?></td>
            <td><?=\backend\models\Article::$sexs[$article->status]?></td>
            <td><?=$article->sort?></td>
            <td><?=date("Y-m-d H:i:s",$article->create_time)?></td>
            <td><?=date("Y-m-d H:i:s",$article->upload_time)?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['edit','id'=>$article->id])?>" class="btn btn-success">编辑</a>
                <a href="<?=\yii\helpers\Url::to(['del','id'=>$article->id])?>" class="btn btn-danger">删除</a>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?=\yii\widgets\LinkPager::widget(['pagination' => $page])?>
