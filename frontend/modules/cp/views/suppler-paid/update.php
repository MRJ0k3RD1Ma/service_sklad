<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\SupplerPaid $model */

$this->title = 'Update Suppler Paid: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Suppler Paids', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="suppler-paid-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
