<?php
$form=\yii\bootstrap\ActiveForm::begin();

echo  $form->field($model,'name');
echo  $form->field($model,'money');
echo  $form->field($model,'sn');
echo  $form->field($model,'isget')->inline()->radioList(\frontend\models\Book::$isget);
echo  $form->field($model,'detail')->textarea();
echo  $form->field($model,'imgFile')->fileInput();
echo $form->field($model,'cate_id')->dropDownList($catesArr);

echo  $form->field($model,'code')->widget(\yii\captcha\Captcha::className(),[
    'captchaAction' =>'book/code',
    'template' => '<div class="row"><div class="col-lg-2">{input}</div><div class="col-lg-1">{image}</div></div>',
]);

echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();