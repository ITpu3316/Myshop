<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($admin,'username');
echo $form->field($admin,'password')->passwordInput();
echo $form->field($admin,'status')->inline()->radioList(\backend\models\Admin::$sta,["value"=>1]);
echo $form->field($admin,'adminRole')->inline()->radioList($adminRole);

echo \yii\bootstrap\Html::submitButton("添加",['class'=>'btn btn-info']);


\yii\bootstrap\ActiveForm::end();

