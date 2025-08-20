<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Payment $model */

$this->title = 'O`zgartirish Payment: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'O`zgartirish';
?>
<div class="payment-update">

       <div class="card">
        <div class="card-body">
        <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
   


</div>
