<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\PaidOther $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="paid-other-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->dropDownList([ 'INCOME' => 'KIRIM', 'OUTCOME' => 'CHIQIM', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'paid_date')->textInput(['type'=>'date']) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\Payment::find()->where(['status'=>1])->all(),'id','name')) ?>

    <?= $form->field($model, 'group_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\PaidOtherGroup::find()->where(['status'=>1])->all(),'id','name')) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>





    <div class="form-group">
        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
