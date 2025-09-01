<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ProductUnit $model */

$this->title = 'O`zgartirish Product Unit: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Product Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'O`zgartirish';
?>
<div class="product-unit-update">

       <div class="card">
        <div class="card-body">
        <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
   


</div>
