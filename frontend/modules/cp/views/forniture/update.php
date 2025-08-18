<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Forniture $model */

$this->title = 'Update Forniture: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Fornitures', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="forniture-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
