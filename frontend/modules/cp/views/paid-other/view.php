<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\PaidOther $model */

$this->title = $model->paid_date;
$this->params['breadcrumbs'][] = ['label' => 'Boshqa to`lovlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="paid-other-view">

    <div class="card">
        <div class="card-body">
            
    <p>
        <?= Html::button('O`zgartirish', ['class' => 'btn btn-primary md-btnupdate','value'=>Yii::$app->urlManager->createUrl(['/cp/paid-other/update', 'id' => $model->id])]) ?>
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
//            'type',
            [
                'attribute'=>'type',
                'value'=>function($d){
                    return Yii::$app->params['paid-other.type'][$d->type];
                },
            ],
            'group.name',
            'description:ntext',
            'paid_date',
            'payment.name',
            'price',
//            'status',
            [
                'attribute'=>'status',
                'value'=>function($d){return Yii::$app->params['status'][$d->status];},
            ],
            'created',
            'updated',
            'register.name',
            'modify.name',
        ],
    ]) ?>

        </div>
    </div>
</div>
