<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\SupplerReturn $model */

$this->title = 'Update Suppler Return: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Suppler Returns', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="suppler-return-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
