<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\PaidWorker $model */

$this->title = 'Qo`shish Paid Worker';
$this->params['breadcrumbs'][] = ['label' => 'Paid Workers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paid-worker-create">

    <div class="card">
        <div class="card-body">
        <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
   

</div>
