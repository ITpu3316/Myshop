<Himl><h1>商品分类列表</h1></Himl><br>
<a href='<?=\yii\helpers\Url::to(['add'])?>' class="glyphicon glyphicon-plus"></a>
<table class="table">
    <tr>
        <td>
            <?= \leandrogehlen\treegrid\TreeGrid::widget([
                'dataProvider' => $date,
                'keyColumnName' => 'id',
                'parentColumnName' => 'parent_id',
                'parentRootValue' => '0', //找到第一个父类的值
                'pluginOptions' => [
                    'initialState' => 'collapsed',
                ],
                'columns' => [
                    'name',
                    'id',
                    'parent_id',
                    'intro',
                    ['class' => 'yii\grid\ActionColumn']
                ]
            ]); ?>
        </td>
    </tr>

</table>
