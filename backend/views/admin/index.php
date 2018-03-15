
<a href='<?=\yii\helpers\Url::to(['add'])?>' class="btn btn-info">添加</a>
<table class="table">
    <tr>
        <td>ID</td>
        <td>用户名</td>
        <td>密码</td>
        <td>性别</td>
        <td>头像</td>
        <td>操作</td>
    </tr>
    <?php foreach ($admins as $admin):?>
        <tr>
            <td><?=$admin->id?></td>
            <td><?=$admin->name?></td>
            <td><?=$admin->password?></td>
            <td><?=\frontend\models\Admin::$sexs[$admin->sex]?></td>
            <td><img src="/<?=$admin->image?>" height="50"></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['edit','id'=>$admin->id])?>" class="btn btn-success">编辑</a>
                <a href="<?=\yii\helpers\Url::to(['del','id'=>$admin->id])?>" class="btn btn-danger">删除</a>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?=\yii\widgets\LinkPager::widget([
    'pagination' => $page,

])?>

