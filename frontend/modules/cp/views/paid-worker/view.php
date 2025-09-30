<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\PaidWorker $model */

$this->title = $model->worker->name;
$this->params['breadcrumbs'][] = ['label' => 'Brigadirlarga to`lovlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="paid-worker-view">

    <div class="card">
        <div class="card-body">
            
    <p>
        <?= Html::button('O`zgartirish' , ['class' => 'btn btn-primary md-btnupdate','value'=>Yii::$app->urlManager->createUrl(['/cp/paid-worker/update', 'id' => $model->id])]) ?>
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
            'worker.name',
            'date',
            'price',
            'description:ntext',
            'payment.name',
//            'status',
            [
                'attribute'=>'status',
                'value'=>function($model){
                    return Yii::$app->params['status'][$model->status];
                }
            ],
            'created',
            'updated',
            'register.name',
            'modify.name',
//            'sale_id',
        ],
    ]) ?>

        </div>
    </div>
</div>
