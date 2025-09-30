<?php

use common\models\PaidWorker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use common\models\Worker;

/** @var yii\web\View $this */
/** @var common\models\search\PaidWorkerSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Brigadirlarga to`langan pullar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paid-worker-index">
    <div class="card">
        <div class="card-body">
            
    <p>
         <button class="btn btn-success md-btncreate" value="<?= Url::to(['create']) ?>" type="button">Brigadirga pul to`lash</button>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'worker_id',
//            'date',
            [
                'attribute'=>'date',
                'value'=>function($d){
                    $url = Yii::$app->urlManager->createUrl(['/cp/paid-worker/view','id'=>$d->id]);
                    return Html::a($d->date,$url);
                },
                'format'=>'raw',
            ],
//            'price',
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
                'filter'=>\yii\helpers\ArrayHelper::map(\common\models\Payment::find()->where(['status'=>1])->all(),'id','name')
            ],
            [
                'attribute'=>'worker_id',
                'value'=>function($model){
                    $url = Yii::$app->urlManager->createUrl(['/cp/worker/view','id'=>$model->worker_id]);
                    return Html::a(Html::encode($model->worker->name),$url);
                },
                'format'=>'raw',
                'filter'=>\yii\helpers\ArrayHelper::map(Worker::find()->where(['status'=>1])->all(),'id','name'),
            ],
//            'description:ntext',
//            'status',
            [
                'attribute'=>'status',
                'value'=>function($model){
                    return Yii::$app->params['status'][$model->status];
                },
                'filter'=>Yii::$app->params['status']
            ],
            'created',
            //'updated',
            //'register_id',
            //'modify_id',
            //'sale_id',
        ],
    ]); ?>


        </div>
    </div>
</div>
