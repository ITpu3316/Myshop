<?php
$form=\yii\bootstrap\ActiveForm::begin();

echo  $form->field($model,'cate_name');


echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
