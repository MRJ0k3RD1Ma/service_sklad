<?php
use yii\helpers\Html;

/* @var $model common\models\Custom */
/* @var $form yii\widgets\ActiveForm */

// Parse value elements from string to array
$elements = json_decode($model->value_elements, true) ?: [];

// Get current value (single value, not array)
$currentValue = $model->value;
?>

<div class="form-group mb-3">
    <label class="form-label" for="custom-<?= $model->key ?>"><?= $model->name ?></label>
    <?= Html::dropDownList(
        "Custom[{$model->key}]",
        $currentValue,
        $elements,
        [
            'id' => "custom-{$model->key}",
            'class' => 'form-control',
            'prompt' => 'Tanlang...'
        ]
    ) ?>
    <?php if (empty($elements)): ?>
        <div class="alert alert-warning mt-2">
            Elementlar mavjud emas. Value_elements maydoniga ma'lumotlarni qo'shing.
        </div>
    <?php endif; ?>
</div>