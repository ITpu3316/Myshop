
<Himl><h1>商品分类列表</h1></Himl><br>
<a href='<?=\yii\helpers\Url::to(['add'])?>' class="btn btn-info glyphicon glyphicon-plus"></a>
<table class="table">
    <tr>
        <td>商品ID</td>
        <td>商品名称</td>
        <td>简介</td>
        <td>父类ID</td>
        <td>操作</td>
    </tr>
    <?php foreach ($categorys as $category):?>
        <tr class="cate" data-tree="<?=$category->tree?>" data-lft="<?=$category->lft?>" data-rgt="<?=$category->rgt?>">
            <td><?=$category->id?></td>
            <td><span class="cate-tr glyphicon glyphicon-chevron-down
"></span><?=$category->nameText?></td>
            <td><?=$category->intro?></td>
            <td><?=$category->parent_id?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['edit','id'=>$category->id])?>" class="btn btn-success glyphicon glyphicon-pencil"></a>
                <a href="<?=\yii\helpers\Url::to(['del','id'=>$category->id])?>" class="btn btn-danger glyphicon glyphicon-trash"></a>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?php
//创建一个js代码快
$Js=<<<JS
//找到需要操作的对象
$(".cate-tr").click(function() {
  
    //当前点击的对象
    var trParent=$(this).parent().parent();
    //当前的点击的tree lft rgt
    var treeParent=trParent.attr('data-tree');
    var lftParent=trParent.attr('data-lft');
    var rgtParent=trParent.attr('data-rgt');
    
    //找到所有的对象tr
    $(".cate").each(function(k,v) {
      
      var tree=$(v).attr('data-tree');
      var lft=$(v).attr('data-lft');
      var rgt=$(v).attr('data-rgt');
      // console.log(v);
      // console.log(tree ,lft,rgt);
   //和点击的对象进行对比，找到他的子孙
    if(tree==treeParent && Number(lft)>lftParent && Number(rgt)<rgtParent){
        //找到子孙
        // console.log(tree,lft,rgt);
        //隐藏
        $(v).toggle();
    }
    });
    
    // console.log(treeParent,lftParent,rgtParent);
    $(this).toggleClass("glyphicon-chevron-down"); 
    $(this).toggleClass("glyphicon-chevron-up"); 
    
    console.log(this);
});


JS;

//注册功能代码
$this->registerJs($Js);

?>