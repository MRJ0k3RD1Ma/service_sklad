<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\FornitureService $model */

$this->title = 'Buyurtma qo`shish';
$this->params['breadcrumbs'][] = ['label' => 'Buyurtmalar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forniture-service-create">

    <div class="card">
        <div class="card-body">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>
