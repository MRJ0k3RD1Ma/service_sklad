<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Paid $model */

$this->title = number_format($model->price,2,'.',' ').' so`m';
$this->params['breadcrumbs'][] = ['label' => 'Tushumlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="paid-view">

    <div class="card">
        <div class="card-body">
            
    <p>
        <?= Html::button('O`zgartirish', ['class' => 'btn btn-primary md-btnupdate','value'=>Yii::$app->urlManager->createUrl(['/cp/paid/update', 'id' => $model->id])]) ?>
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
//            'sale_id',
            'date',
            'price',
            'payment.name',
            [
                'attribute'=>'client_id',
                'value'=>function($d){
                    $url = Yii::$app->urlManager->createUrl(['/cp/client/view','id'=>$d->client_id]);
                    return Html::a($d->client->name.'<br>'.$d->client->balance,$url);
                },
                'format'=>'raw',
            ],
            [
                'attribute'=>'sale_id',
                'value'=>function($d){
                    if($d->sale_id){
                        $url = Yii::$app->urlManager->createUrl(['/cp/sale/view','id'=>$d->sale_id]);
                        return Html::a('#'.$d->sale->code.' '.$d->sale->date,$url);
                    }else{
                        return null;
                    }
                },
                'format'=>'raw',
            ],
//            'client_id',

//            'status',
            [
                'attribute'=>'status',
                'value'=>function($d){
                    return Yii::$app->params['status'][$d->status];
                }
            ],
            'created',
            'updated',
            'register.name',
            'modify.name'
        ],
    ]) ?>

        </div>
    </div>
</div>
