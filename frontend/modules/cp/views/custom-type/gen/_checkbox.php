<?php
use yii\helpers\Html;

/* @var $model common\models\Custom */
/* @var $form yii\widgets\ActiveForm */

// Checkbox value should be 1 if checked, 0 if not
$isChecked = $model->value == 1;
?>

<div class="form-group mb-3">
    <div class="form-check">
        <?= Html::hiddenInput("Custom[{$model->key}]", 0) ?>
        <?= Html::checkbox(
            "Custom[{$model->key}]",
            $isChecked,
            [
                'value' => $model->value_elements,
                'id' => "custom-{$model->key}",
                'class' => 'form-check-input'
            ]
        ) ?>
        <label class="form-check-label" for="custom-<?= $model->key ?>">
            <?= $model->name ?>
        </label>
    </div>
</div>