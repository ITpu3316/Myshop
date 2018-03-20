<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/18 0018
 * Time: 15:29
 */

$form=\yii\bootstrap\ActiveForm::begin();

echo $form->field($cate,'name');
echo $form->field($cate,'parent_id')->textInput(['value'=>0]);
echo \liyuze\ztree\ZTree::widget([
    'setting' => '{
			data: {
				simpleData: {
					enable: true,
					pIdKey:"parent_id",
				} 
			},
			
			callback: {
				onClick: onClick,
			}
           
		}',
    'nodes' =>
        $cateJson,
]);
echo $form->field($cate,'intro')->textarea();
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);

\yii\bootstrap\ActiveForm::end();?>

<script>
	function onClick(e,treeId, treeNode) {
	    //找到父类ID
        $("#category-parent_id").val(treeNode.id);

        console.log(treeNode.id);
//        var zTree = $.fn.zTree.getZTreeObj("treeDemo");
//        zTree.expandNode(treeNode);
    }
</script>

<?php
//定义json代码快
$js=<<<JS
    //得到树形结构的对象
    var treeObj=$.fn.zTree.getZTreeObj("w1");
    //得到当前的对象
    var node = treeObj.getNodeByParam("id", "$cate->parent_id", null);
    //选中当前的节点
    treeObj.selectNode(node);
    //设置父类id的值
    $("#category-parent_id").val($cate->parent_id);
    //调用展开方法
    treeObj.expandAll(true);
JS;
    //追加代码块到jQuery之后
    $this->registerJs($js);
?>