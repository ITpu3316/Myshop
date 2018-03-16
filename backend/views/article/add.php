<?php
$form=\yii\bootstrap\ActiveForm::begin();

echo  $form->field($model,'name');
echo  $form->field($model,'cate_id')->dropDownList($cateArr);
echo  $form->field($model,'sort')->textInput(['value'=>100]);
echo  $form->field($model,'status')->inline()->radioList(\backend\models\Article::$sexs,["value"=>1]);
echo  $form->field($model,'intro')->textarea();
echo  $form->field($content,'detail')->textarea();


echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
