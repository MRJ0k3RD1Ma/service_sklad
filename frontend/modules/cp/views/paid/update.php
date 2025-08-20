<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Paid $model */

$this->title = 'O`zgartirish Paid: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Paids', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'O`zgartirish';
?>
<div class="paid-update">

       <div class="card">
        <div class="card-body">
        <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
   


</div>
