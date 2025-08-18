<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ClientCar $model */

$this->title = 'O`zgartirish: ' . $model->model . ' - ' . $model->number;
$this->params['breadcrumbs'][] = ['label' => $model->client->name, 'url' => ['client/view', 'id' => $model->client_id]];
$this->params['breadcrumbs'][] = ['label' => 'Moshinalar', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->model.' - '.$model->number, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="client-car-update">

    <div class="card">
        <div class="card-body">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

</div>
