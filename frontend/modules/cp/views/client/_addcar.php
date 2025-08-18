<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $model \common\models\ClientCar*/
?>

<?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model,'model')->textInput()?>
    <?= $form->field($model,'number')->textInput()?>
    <?= $form->field($model,'run')->textInput()?>
    <?= $form->field($model,'last_visit')->textInput(['type'=>'date'])?>
    <?= $form->field($model,'call_date')->textInput(['type'=>'date'])?>
    <?= $form->field($model,'ads')->textInput()?>

    <button class="btn btn-success">Saqlash</button>

<?php ActiveForm::end()?>
