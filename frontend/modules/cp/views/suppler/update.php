<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Suppler $model */

$this->title = 'Update Suppler: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Supplers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="suppler-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
