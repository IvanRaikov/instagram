<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php $form  = ActiveForm::begin();?>
<?= $form->field($model, 'picture')->fileInput()?>
<?= Html::submitButton('отправить',['class'=>'btn btn-success']);?>
<?php ActiveForm::end()?>