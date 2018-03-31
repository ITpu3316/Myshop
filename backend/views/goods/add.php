<?php
$form=\yii\bootstrap\ActiveForm::begin();

echo  $form->field($model,'name');
echo  $form->field($model,'sn');
echo  $form->field($model,'logo')->widget(\manks\FileInput::className(),[]);
echo  $form->field($model,'images')->widget('manks\FileInput', [
    'clientOptions' => [
        'pick' => [
            'multiple' => true,
        ],
        // 'server' => Url::to('upload/u2'),
        // 'accept' => [
        // 	'extensions' => 'png',
        // ],
    ],
]);
echo  $form->field($model,'goods_category_id')->dropDownList($cateArr,['prompt'=>'请选择.....']);
echo  $form->field($model,'brand_id')->dropDownList($brandArr,['prompt'=>'请选择.....']);
echo  $form->field($model,'market_price')->textInput(['value'=>1]);
echo  $form->field($model,'shop_price')->textInput(['value'=>1]);
echo  $form->field($model,'stock')->textInput(['value'=>666]);
echo  $form->field($model,'sort')->textInput(['value'=>100]);
echo  $form->field($model,'status')->inline()->radioList(\backend\models\Goods::$ses);
echo  $form->field($content,'content')->widget('kucha\ueditor\UEditor',[]);


echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();
