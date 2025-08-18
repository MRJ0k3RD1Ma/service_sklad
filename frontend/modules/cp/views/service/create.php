<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Goods $model */

$this->title = 'Create Goods';
$this->params['breadcrumbs'][] = ['label' => 'Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
