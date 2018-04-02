<?php
/* @var $this yii\web\View */
?>
<h1>用户列表</h1>
<a href='<?=\yii\helpers\Url::to(['add'])?>' class="btn btn-info glyphicon glyphicon-plus"></a>
<table class="table">
    <tr>
        <td>ID</td>
        <td>用户名</td>
        <td>状态</td>
        <td>IP地址</td>
        <td>注册时间</td>
        <td>最后登录时间</td>
        <td>操作</td>
    </tr>
    <?php foreach ($admins as $admin):?>
        <tr>
            <td><?=$admin->id?></td>
            <td><?=$admin->username?></td>
            <td><?=\backend\models\Admin::$sta[$admin->status]?></td>
            <td><?=long2ip($admin->ip)?></td>
            <td><?=date("Y-m-d H:i:s",$admin->add_time)?></td>
            <td><?=date("Y-m-d H:i:s",$admin->last_time)?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['edit','id'=>$admin->id])?>" class="btn btn-success glyphicon glyphicon-pencil"></a>
                <a href="<?=\yii\helpers\Url::to(['del','id'=>$admin->id])?>" class="btn btn-danger glyphicon glyphicon-trash"></a>
            </td>
        </tr>
    <?php endforeach;?>
</table>


