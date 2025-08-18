<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\search\SaleSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="sale-search">

    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'options' => [
            'class'=>'form-inline',
        ]
    ]); ?>

    <?= $form->field($model, 'period_start')->textInput(['type'=>'date'])->label('Sanadan &nbsp;') ?>
    &nbsp;- &nbsp;
    <?= $form->field($model, 'period_end')->textInput(['type'=>'date'])->label('Sanagacha &nbsp;') ?>

    &nbsp;&nbsp;
    <div class="form-group">
        <?= Html::submitButton('Qidirish', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

