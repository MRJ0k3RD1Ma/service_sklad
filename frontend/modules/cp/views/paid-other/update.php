<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\PaidOther $model */

$this->title = 'O`zgartirish Paid Other: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Paid Others', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'O`zgartirish';
?>
<div class="paid-other-update">

       <div class="card">
        <div class="card-body">
        <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
   


</div>
