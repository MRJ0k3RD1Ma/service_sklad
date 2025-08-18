<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Goods $model */

$this->title = 'Update Goods: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="goods-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
