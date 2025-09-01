<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ProductUnit $model */

$this->title = 'Qo`shish Product Unit';
$this->params['breadcrumbs'][] = ['label' => 'Product Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-unit-create">

    <div class="card">
        <div class="card-body">
        <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
   

</div>
