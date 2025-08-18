<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ClientType $model */

$this->title = 'Update Client Type: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Client Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="client-type-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
