<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\PaidOtherGroup $model */

$this->title = 'O`zgartirish Paid Other Group: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Paid Other Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'O`zgartirish';
?>
<div class="paid-other-group-update">

       <div class="card">
        <div class="card-body">
        <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
   


</div>
