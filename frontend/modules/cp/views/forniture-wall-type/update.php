<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\FornitureWallType $model */

$this->title = 'Update Forniture Wall Type: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Forniture Wall Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="forniture-wall-type-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
