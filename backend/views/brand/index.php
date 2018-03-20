<Himl><h1>品牌列表</h1></Himl><br>
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
            <td><?php
                //判断是不是七牛云上传的路径
                $imaPath=strpos($brand->logo,"http://")===false?"/".$brand->logo:$brand->logo;
                echo \yii\bootstrap\Html::img($imaPath,['height'=>40]);
                ?>
            </td>
            <td><?=$brand->sort?></td>
            <td><?=\backend\models\Brand::$sexs[$brand->status]?></td>
            <td><?=$brand->intro?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['edit','id'=>$brand->id])?>" class="btn btn-success glyphicon glyphicon-pencil" ></a>
                <a href="<?=\yii\helpers\Url::to(['del','id'=>$brand->id])?>" class="btn btn-danger glyphicon glyphicon-trash"></a>
            </td>
        </tr>
    <?php endforeach;?>
</table>

<?=\yii\widgets\LinkPager::widget(['pagination' => $page])?>
