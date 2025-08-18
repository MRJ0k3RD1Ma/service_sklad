<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\GoodsGroup $model */

$this->title = 'Create Goods Group';
$this->params['breadcrumbs'][] = ['label' => 'Goods Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-group-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
