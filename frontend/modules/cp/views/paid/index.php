<?php

use common\models\Paid;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\PaidSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tushumlar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paid-index">
    <div class="card">
        <div class="card-body">
            
    <p>
         <button class="btn btn-success md-btncreate" value="<?= Url::to(['create']) ?>" type="button">Tushum qo'shish</button>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'sale_id',
            [
                'attribute'=>'date',
                'value'=>function($d){
                    $url = Yii::$app->urlManager->createUrl(['/cp/paid/view','id'=>$d->id]);
                    return Html::a($d->date,$url);
                },
                'format'=>'raw',
            ],
//            'price',
            [
                'attribute'=>'client_id',
                'value'=>function($d){
                    $url = Url::toRoute(['/cp/client/view','id'=>$d->client_id]);
                    return Html::a($d->client->name,$url);
                },
                'format'=>'raw',
                'filter'=>\yii\helpers\ArrayHelper::map(\common\models\Client::find()->where(['status'=>1])->all(),'id','name')
            ],
            [
                'attribute'=>'price',
                'value'=>function($d){
                    return number_format($d->price,2,'.',' ');
                }
            ],
//            'payment_id',
            [
                'attribute'=>'payment_id',
                'value'=>function($d){
                    return $d->payment->name;
                },
                'filter'=>\yii\helpers\ArrayHelper::map(\common\models\Payment::find()->where(['status'=>1])->all(),'id','name'),
            ],
//            'client_id',
            //'date',
            //'status',
            [
                'attribute'=>'status',
                'value'=>function($d){
                    return Yii::$app->params['status'][$d->status];
                },
                'filter'=>Yii::$app->params['status']
            ],
            'created',
            //'updated',
            //'register_id',
            //'modify_id',
        ],
    ]); ?>


        </div>
    </div>
</div>
