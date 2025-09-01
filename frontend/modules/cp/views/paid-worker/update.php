<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\PaidWorker $model */

$this->title = 'O`zgartirish Paid Worker: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Paid Workers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'O`zgartirish';
?>
<div class="paid-worker-update">

       <div class="card">
        <div class="card-body">
        <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
   


</div>
