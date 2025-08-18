<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\ClientCar $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="client-car-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'run')->textInput() ?>

    <?= $form->field($model, 'call_date')->textInput(['type'=>'date']) ?>

    <?= $form->field($model, 'ads')->textarea(['rows' => 6]) ?>


    <div class="form-group">
        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
