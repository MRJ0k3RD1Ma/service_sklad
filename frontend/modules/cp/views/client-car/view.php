<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\ClientCar $model */

$this->title = $model->model .' - ' . $model->number;
$this->params['breadcrumbs'][] = ['label' => 'Moshinalar', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->client->name, 'url' => ['client/view', 'id' => $model->client_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="client-car-view">


    <div class="card">
        <div class="card-body">
            <div class="row">
            <div class="col-md-3">
                <p>
                    <?= Html::a('O\'chirish', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('O`zgartirish', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </p>

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        [
                            'attribute'=>'client_id',
                            'value'=>function($model){
                                $url = Yii::$app->urlManager->createUrl(['/cp/client/view','id'=>$model->client_id]);
                                return Html::a($model->client->name.'<br>'.
                                    $model->client->phone.'<br>'.
                                    $model->client->balans.' so`m',$url);
                            },
                            'format'=>'raw',
                        ],
                        'model',
                        'number',
                        'run',
                        'call_date',
                        'ads:ntext',
                        'status',
                        'created',
                        'updated',
                        'last_visit',
                    ],
                ]) ?>
                <hr>
                <img src="/upload/<?= $model->client->image ?>" alt="<?= $model->client->name ?>" style="width: 100%; height: auto; border-radius: 5px;">
            </div>

                <div class="col-md-9">
                    <h4>So'ngi tashriflar ro'yhati</h4>
                    <?= GridView::widget([
                        'dataProvider' => $visitDataProvider,
                        'filterModel' => $visitSearchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

//                                            'id',
//                                            'client_id',
//                                            'car_id',
                            [
                                'attribute'=>'car_number',
                                'value'=>function($d){
                                    $url = Yii::$app->urlManager->createUrl(['/cp/client-car/view','id'=>$d->car_id]);
                                    return Html::a($d->car->model.'<br>'.$d->car->number,$url);
                                },
                                'format'=>'raw'
                            ],
//                                            'date',
                            [
                                'attribute'=>'date',
                                'value'=>function($d){
                                    $url = Yii::$app->urlManager->createUrl(['/cp/visit/view','id'=>$d->id]);
                                    return Html::a($d->date,$url);
                                },
                                'format'=>'raw'
                            ],
                            'price',
                            'debt',
                            'credit',
                            //'register_id',
                            //'modify_id',
                            //'status',
                            //'created',
                            //'updated',
                            //'state',
                            //'sale_id',
                            //'user_id',
                        ],
                    ]); ?>
                </div>

            </div>


        </div>
    </div>

</div>
