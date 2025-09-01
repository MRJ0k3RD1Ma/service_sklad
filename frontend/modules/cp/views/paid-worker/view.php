<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\PaidWorker $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Paid Workers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="paid-worker-view">

    <div class="card">
        <div class="card-body">
            
    <p>
        <?= Html::a('O`zgartirish', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('O`chirish', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Siz rostdan ham ushbu ma`lumotni o`chirmoqchimisiz?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'worker_id',
            'date',
            'price',
            'description:ntext',
            'payment_id',
            'status',
            'created',
            'updated',
            'register_id',
            'modify_id',
            'sale_id',
        ],
    ]) ?>

        </div>
    </div>
</div>
