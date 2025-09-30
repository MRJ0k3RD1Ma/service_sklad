<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
/** @var yii\web\View $this */
/** @var common\models\Worker $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Workers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="worker-view">

    <div class="card">
        <div class="card-body">
            
    <p>
        <?= Html::button('O`zgartirish', ['class' => 'btn btn-primary md-btnupdate','value'=>Yii::$app->urlManager->createUrl(['/cp/worker/update','id'=>$model->id])]) ?>
        <?= Html::a('O`chirish', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Siz rostdan ham ushbu ma`lumotni o`chirmoqchimisiz?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::button('<span class="fa fa-money"></span> To`lov qilish',['class'=>'btn btn-primary md-btncreate','value'=>Yii::$app->urlManager->createUrl(['/cp/worker/paying','id'=>$model->id])])?>
    </p>

            <div class="row">
                <div class="col-md-4">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'name',
                            'phone',
                            'balance',
                            'description:ntext',
//            'image',
                            [
                                'attribute'=>'image',
                                'value'=>function($d){
                                    return Html::img('/upload/'.$d->image,['style'=>'height:200px;']);
                                },
                                'format'=>'raw',
                            ],
//            'status',
                            [
                                'attribute'=>'status',
                                'value'=>function($d){
                                    return Yii::$app->params['status'][$d->status];
                                }
                            ],
                            'created',
                            'updated',
//            'register_id',
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
                            ],
//            'modify_id',
                        ],
                    ]) ?>
                </div>
                <div class="col-md-8">
                    <div class="pd-20 card-box">
                        <h5 class="h4 text-blue mb-20">Mijoz bilan munosabatlar</h5>
                        <div class="tab">
                            <ul class="nav nav-tabs customtab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#sales" role="tab" aria-selected="true">Shartnomalar ro'yhati</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#paid" role="tab" aria-selected="false">To'lovlar</a>
                                </li>

                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="sales" role="tabpanel" style="padding-top:20px;">

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
                                                'attribute'=>'product_id',
                                                'value'=>function($model){
                                                    return $model->product->name;
                                                },
                                                'filter'=>\yii\helpers\ArrayHelper::map(\common\models\Product::find()->where(['status'=>1])->all(),'id','name')
                                            ],
                                            //'product_id',
                                            'price',
                                            //'debt',
//                                            'credit',
//            'worker_id',
                                            [
                                                'attribute'=>'worker_id',
                                                'value'=>function($model){
                                                    return Html::a($model->worker->name, Url::to(['worker/view', 'id' => $model->worker_id]));
                                                },
                                                'format'=>'raw',
                                                'filter'=>ArrayHelper::map(\common\models\Worker::find()->where(['status'=>1])->all(),'id','name')
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

                                <div class="tab-pane fade" id="paid" role="tabpanel" style="padding-top:20px;">

                                    <?= \yii\grid\GridView::widget([
                                        'dataProvider' => $dataPaidProvider,
                                        'filterModel' => $searchPaidModel,
                                        'columns' => [
                                            ['class' => 'yii\grid\SerialColumn'],

//                                            'id',
//                                            'sale_id',
                                            'date',
//                                            'price',
                                            [
                                                'attribute'=>'price',
                                                'value'=>function($d){
                                                    return number_format($d->price,2,'.',' ').' so`m';
                                                }
                                            ],
//                                            'payment_id',
                                            [
                                                'attribute'=>'payment_id',
                                                'value'=>function($d){
                                                    return $d->payment->name;
                                                },
                                                'filter'=>\yii\helpers\ArrayHelper::map(\common\models\Payment::find()->where(['status'=>1])->all(),'id','name')
                                            ],
//                                            'client_id',
                                            //'date',
//                                            'status',
                                            'created',
                                            //'updated',
                                            //'register_id',
                                            //'modify_id',
                                            [
                                                'label'=>'',
                                                'value'=>function($d){
                                                    $url_delete = Yii::$app->urlManager->createUrl(['/cp/worker/deletepaying','id'=>$d->id]);
                                                    $url_update = Yii::$app->urlManager->createUrl(['/cp/worker/updatepaying','id'=>$d->id]);
                                                    return "
                                                        <button class='btn btn-primary md-btnupdate' value='{$url_update}'><span class='fa fa-edit'></span></button>
                                                        <a href='{$url_delete}' class='btn btn-danger' data-method='post' data-confirm='Siz rostdan ham ushbu elementni o`chirmoqchimisiz?'><span class='fa fa-trash'></span></a>
                                                    ";
                                                },
                                                'format'=>'raw'
                                            ],
                                        ],
                                    ]); ?>


                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>

        </div>
    </div>
</div>
