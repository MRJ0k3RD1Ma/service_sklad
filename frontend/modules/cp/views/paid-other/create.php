<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\PaidOther $model */

$this->title = 'Qo`shish Paid Other';
$this->params['breadcrumbs'][] = ['label' => 'Paid Others', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paid-other-create">

    <div class="card">
        <div class="card-body">
        <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
   

</div>
