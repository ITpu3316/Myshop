
<Himl><h1>文章列表</h1></Himl><br>
<a href='<?=\yii\helpers\Url::to(['add'])?>' class="btn btn-info glyphicon glyphicon-plus"></a>
<table class="table">
    <tr>
        <td>ID</td>
        <td>文章名称</td>
        <td>文章分类</td>
        <td>文章简介</td>
        <td>文章状态</td>
        <td>文章排序</td>
<!--        <td>文章内容</td>-->
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
            <td>
                <?php
                if($article->status){
                    echo \yii\bootstrap\Html::a("",[' ','id'=>$article->id],['class'=>'glyphicon glyphicon-ok']);
                }else{
                    echo \yii\bootstrap\Html::a("",[' ','id'=>$article->id],['class'=>'glyphicon glyphicon-remove']);
                }
                ?></td>
            <td><?=$article->sort?></td>
<!--            <td>-->
<!--                --><?php
//                    echo \yii\bootstrap\Html::a("",['content-list','id'=>$article->id],['class'=>'glyphicon glyphicon-eye-open','data-toggle'=>"modal" ,'data-target'=>"#hide"]);
//
//                ?>
<!--            </td>-->
            <td><?=date("Y-m-d H:i:s",$article->create_time)?></td>
            <td><?=date("Y-m-d H:i:s",$article->upload_time)?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['edit','id'=>$article->id])?>" class="btn btn-success glyphicon glyphicon-pencil"></a>
                <a href="<?=\yii\helpers\Url::to(['del','id'=>$article->id])?>" class="btn btn-danger glyphicon glyphicon-trash"></a>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<!--<div class="modal fade" id="hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">-->
<!--    <div class="modal-dialog" role="document">-->
<!--        <div class="modal-content">-->
<!--            <div class="modal-header">-->
<!--                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<!--                <h4 class="modal-title" id="myModalLabel">文章内容</h4>-->
<!--            </div>-->
<!--            <div class="modal-body">-->
<!--                --><?php
//                    echo $article->contents->detail;
//                ?>
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<?=\yii\widgets\LinkPager::widget(['pagination' => $page])?>
