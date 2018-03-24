<?php
/* @var $this yii\web\View */
?>
<h1>文章列表</h1>
<a href='<?=\yii\helpers\Url::to(['add'])?>' class="btn btn-info glyphicon glyphicon-plus"></a>
<table class="table">
    <tr>
        <td>名称</td>
        <td>描述</td>
        <td>权限</td>
        <td>操作</td>
    </tr>
    <?php foreach ($roles as $role):?>
        <tr>
            <td><?=$role->name?></td>
            <td><?=$role->description?></td>
            <td>
                <?php
                //创建auth对象
                $auth=\Yii::$app->authManager;
                //通过当前角色名得到权限
                $pers=$auth->getPermissionsByRole($role->name);
//                $perArr=\yii\helpers\ArrayHelper::map($pers,'name','description');
//                var_dump($pers);exit();
                $html="";
                //循环遍历
                foreach ($pers as $per){
//                    var_dump($per);
                    $html .= $per->description.",";
                }
               // exit();
                //去掉最后的，号
                $html=trim($html,',');
                echo $html;
                ?>
            </td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['edit','name'=>$role->name])?>" class="btn btn-success glyphicon glyphicon-pencil"></a>
                <a href="<?=\yii\helpers\Url::to(['del','name'=>$role->name])?>" class="btn btn-danger glyphicon glyphicon-trash"></a>
            </td>
        </tr>
    <?php endforeach;?>
</table>


