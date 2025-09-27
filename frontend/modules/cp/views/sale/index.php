<?php

use common\models\Sale;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\SaleSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Shartnomalar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sale-index">
    <div class="card">
        <div class="card-body">
            
    <p>
         <a class="btn btn-success" href="<?= Url::to(['create']) ?>" type="button">Shartnoma qo'shish</a>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'date',
            'code',
//            'code_id',
//            'client_id',
            [
                'attribute'=>'client_name',
                'value'=>function($model){
                    $url = url::toRoute(['client/view', 'id' => $model->client_id]);
                    return Html::a($model->client->name, $url);
                },
            ],
            [
                'attribute'=>'product_id',
                'value'=>function($model){
                    return $model->product->name;
                },
                'filter'=>\yii\helpers\ArrayHelper::map(\common\models\Product::find()->where(['status'=>1])->all(),'id','name')
            ],
            //'product_id',
            'price',
            //'debt',
            'credit',
//            'worker_id',
            [
                'attribute'=>'worker_id',
                'value'=>function($model){
                    return Html::a($model->worker->name, Url::to(['worker/view', 'id' => $model->worker_id]));
                }
            ],
            //'state',
            [
                'attribute'=>'state',
                'value'=>function($model){
                    return Yii::$app->params['sale.state'][$model->state];
                },
                'filter'=>Yii::$app->params['sale.state']
            ],
            //'created',
            //'updated',
            //'register_id',
            //'modify_id',
            //'status',
            //'volume',
            //'volume_estimated',
            //'address',
        ],
    ]); ?>


        </div>
    </div>
</div>
