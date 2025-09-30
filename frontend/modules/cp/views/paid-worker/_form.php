<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\PaidWorker $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="paid-worker-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'worker_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\Worker::find()->where(['status'=>1])->all(),'id','name')) ?>

    <?= $form->field($model, 'date')->textInput(['type'=>'date']) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'payment_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\Payment::find()->where(['status'=>1])->all(),'id','name')) ?>


    <div class="form-group">
        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
