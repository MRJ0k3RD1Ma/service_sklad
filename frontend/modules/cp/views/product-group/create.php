<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ProductGroup $model */

$this->title = 'Qo`shish Product Group';
$this->params['breadcrumbs'][] = ['label' => 'Product Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-group-create">

    <div class="card">
        <div class="card-body">
        <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
   

</div>
