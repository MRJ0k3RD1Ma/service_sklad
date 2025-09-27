<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Sale $model */

$this->title = 'O`zgartirish' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Shartnomalar', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->code, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'O`zgartirish';
?>
<div class="sale-update">

       <div class="card">
        <div class="card-body">
        <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
   


</div>
