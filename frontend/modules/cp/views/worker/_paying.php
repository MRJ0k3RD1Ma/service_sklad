<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Paid $model */
/** @var common\models\Sale $sale */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="paid-form">

    <?php $form = ActiveForm::begin(); ?>

    <h4>Mijozdan to`lov qabul qilish</h4>
    <p style="padding:0; margin:0;"><b>Mijoz: </b><?= $model->worker->name?></p>
    <p style="margin:0; padding:0;"><b>Mijoz balansi: </b><?= $model->worker->balance?></p>

    <?= $form->field($model, 'date')->textInput(['type'=>'date']) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\Payment::find()->where(['status'=>1])->all(),'id','name'),['prompt'=>'To`lov turini tanlang']) ?>

    <?= $form->field($model,'description')->textarea(['rows'=>3])?>
    <div class="form-group">
        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
