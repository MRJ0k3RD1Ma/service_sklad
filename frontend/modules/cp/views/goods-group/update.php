<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\GoodsGroup $model */

$this->title = 'Update Goods Group: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Goods Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="goods-group-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
