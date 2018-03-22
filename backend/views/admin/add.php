<?php
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'username');
echo $form->field($model,'password')->passwordInput();
echo $form->field($model,'status')->inline()->radioList(\backend\models\Admin::$sta,["value"=>1]);

echo \yii\bootstrap\Html::submitButton("添加",['class'=>'btn btn-info']);


\yii\bootstrap\ActiveForm::end();

