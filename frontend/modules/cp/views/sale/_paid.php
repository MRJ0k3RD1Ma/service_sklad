<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Paid $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="sale-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model,'date')->textInput(['type'=>'date'])?>

    <?= $form->field($model,'price')->textInput()?>

    <?= $form->field($model,'payment_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\Payment::find()->all(),'id','name'))?>

    <div class="form-group">
        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
