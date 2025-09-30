<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
/** @var yii\web\View $this */
/** @var common\models\Product $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Xizmatlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">


    <div class="card">
        <div class="card-body">
            
    <p>
        <?= Html::button('O`zgartirish', ['class' => 'btn btn-primary md-btnupdate','value'=>Yii::$app->urlManager->createUrl(['/cp/product/update','id'=>$model->id])]) ?>
        <?= Html::a('O`chirish', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Siz rostdan ham ushbu ma`lumotni o`chirmoqchimisiz?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

            <div class="row">
                <div class="col-md-4">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
//                            'type',
                            'name',
//                            'group_id',
                            [
                                'attribute'=>'group_id',
                                'value'=>function($d){
                                    return $d->group->name;
                                }
                            ],
//                            'unit_id',
                            [
                                'attribute'=>'unit_id',
                                'value'=>function($d){
                                    return $d->unit->name;
                                }
                            ],
//                            'image',
                            [
                                'attribute'=>'image',
                                'value'=>function($d){
                                    return Html::img($d->image,['style'=>'height:200px;']);
                                },
                                'format'=>'raw',
                            ],
                            'price',
                            'price_worker',
                            'min_volume',
                            'volume_price',
//                            'status',
                            [
                                'attribute'=>'status',
                                'value'=>function($d){
                                    return Yii::$app->params['status'][$d->status];
                                },
                            ],
                            'created',
                            'updated',
//                            'register_id',
//                            'modify_id',
                            [
                                'attribute'=>'register_id',
                                'value'=>function($d){
                                    return $d->register->name;
                                }
                            ],
                            [
                                'attribute'=>'modify_id',
                                'value'=>function($d){
                                    return $d->modify->name;
                                }
                            ]
                        ],
                    ]) ?>
                </div>
                <div class="col-md-8">
                    <h5>Ushbu xizmat ko'rsatilgan shartnomalar ro'yhati</h5>
                    <?= \yii\grid\GridView::widget([
                        'dataProvider' => $dataSaleProvider,
                        'filterModel' => $searchSaleModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'date',
//            'code',
                            [
                                'attribute'=>'code',
                                'value'=>function($d){
                                    $url = Yii::$app->urlManager->createUrl(['/cp/sale/view','id'=>$d->id]);
                                    return Html::a('#'.Html::encode($d->code.' '.$d->date),$url);
                                },'format'=>'raw'
                            ],
//            'code_id',
//            'client_id',
                            [
                                'attribute'=>'client_id',
                                'value'=>function($d){
                                    $url = Yii::$app->urlManager->createUrl(['/cp/client/view','id'=>$d->id]);
                                    return Html::a(Html::encode($d->client->name),$url);
                                },
                                'format'=>'raw'
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
                                },
                                'format'=>'raw'
                            ],
                            //'state',
                            [
                                'attribute'=>'state',
                                'value'=>function($model){
                                    return Yii::$app->params['sale.state'][$model->state];
                                },
                                'filter'=>Yii::$app->params['sale.state']
                            ],
                            [
                                'attribute'=>'status',
                                'value'=>function($model){
                                    return Yii::$app->params['status'][$model->status];
                                },
                                'filter'=>Yii::$app->params['status']
                            ],

                        ],
                    ]); ?>
                </div>
            </div>

        </div>
    </div>
</div>
