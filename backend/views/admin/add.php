<?php
$form=\yii\bootstrap\ActiveForm::begin();

echo  $form->field($model,'name');
echo  $form->field($model,'password');
echo  $form->field($model,'sex')->inline()->radioList(\frontend\models\Admin::$sexs);
echo  $form->field($model,'images')->fileInput();
echo  $form->field($model,'code')->widget(\yii\captcha\Captcha::className(),[
    'captchaAction' => 'admin/code',
    'template' => '<div class="row"><div class="col-lg-2">{input}</div><div class="col-lg-1">{image}</div></div>',
]);

echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
