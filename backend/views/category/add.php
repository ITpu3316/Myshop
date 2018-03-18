<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/18 0018
 * Time: 15:29
 */

$form=\yii\bootstrap\ActiveForm::begin();

echo $form->field($cate,'name');
echo $form->field($cate,'parent_id')->hiddenInput(['value'=>0]);
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
$js=<<<EOF
    var treeObj=$.fn.zTree.getZTreeObj("w1");
    treeObj.expandAll(true);
EOF;
$this->registerJs($js);
?>