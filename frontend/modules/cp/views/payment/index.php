<?php

use common\models\Payment;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\PaymentSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'To`lov turlari';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-index">
    <div class="card">
        <div class="card-body">
            
    <p>
         <button class="btn btn-success md-btncreate" value="<?= Url::to(['create']) ?>" type="button">To`lov turi qo'shish</button>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'name',
            [
                'attribute'=>'name',
                'value'=>function($d){
                    $url = Yii::$app->urlManager->createUrl(['/cp/payment/update','id'=>$d->id]);
                    return Html::button($d->name,['value'=>$url,'class'=>'md-btnupdate btn btn-link']);
                },
                'format'=>'raw',
            ],
//            'status',
            [
                'attribute' => 'status',
                'value'=>function($d){
                    return Yii::$app->params['status'][$d->status];
                },
                'filter' => Yii::$app->params['status'],
            ],
            'created',
            'updated',
            [
                'label'=>'',
                'format'=>'raw',
                'value'=>function($d){
                    $url = Yii::$app->urlManager->createUrl(['/cp/payment/delete','id'=>$d->id]);
                    return Html::a('<span class="fa fa-trash"></span>',$url,['class'=>'btn btn-danger','data-method'=>'post','data-confirm'=>'Siz rostdan ham ushbu elementni o`chirmoqchimisiz?']);
                }
            ],
            //'register_id',
            //'modify_id',
        ],
    ]); ?>


        </div>
    </div>
</div>
