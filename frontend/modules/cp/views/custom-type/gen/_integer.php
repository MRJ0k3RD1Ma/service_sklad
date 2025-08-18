<?php
use yii\helpers\Html;
/* @var $model common\models\Custom */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-group">
    <label for="custom-<?= $model->key ?>"><?= $model->name ?></label>
    <?= Html::textInput(
        "Custom[{$model->key}]",
        $model->value,
        [
            'id' => "custom-{$model->key}",
            'type' => 'number',
            'class' => 'form-control',
            'placeholder' => 'Son kiriting'
        ]
    ) ?>
</div>