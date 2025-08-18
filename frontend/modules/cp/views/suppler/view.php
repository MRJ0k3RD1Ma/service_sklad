<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Suppler $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Supplers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="suppler-view">


    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <p>
                        <button class="btn btn-primary md-btnupdate" value="<?= Yii::$app->urlManager->createUrl(['/cp/suppler/update','id'=>$model->id])?>">O`zgartirish</button>
                        <?= Html::a('O`chirish', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                        <button class="btn btn-success md-btnupdate" value="<?= Yii::$app->urlManager->createUrl(['/cp/suppler/pay','id'=>$model->id])?>">To'lov qilish</button>

                    </p>

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'name',
                            'phone',
                            'phone_two',
                            'comment',

                            'balans',
                            'debt',
                            'credit',
//                            'status',
                            [
                                'attribute'=>'status',
                                'value'=>function($model){
                                    return Yii::$app->params['status'][$model->status];
                                }
                            ],
                            'created',
                            'updated',
                        ],
                    ]) ?>
                </div>

                <div class="col-md-9">

                    <div class="pd-20 card-box">
                        <h5 class="h4 text-blue mb-20">Yetkazuvchi bilan munosabatlar</h5>
                        <div class="tab">
                            <ul class="nav nav-tabs customtab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#home2" role="tab" aria-selected="true">Kelgan mahsulotlar</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#profile2" role="tab" aria-selected="false">To'lovlar</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#contact2" role="tab" aria-selected="false">Qaytarib yuborilganlar</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="home2" role="tabpanel" style="padding-top:20px;">
                                        <?= \yii\grid\GridView::widget([
                                            'dataProvider' => $dataProvider,
                                            'filterModel' => $searchModel,
                                            'columns' => [
                                                ['class' => 'yii\grid\SerialColumn'],

                                                [
                                                    'attribute'=>'code',
                                                    'value'=>function($d){
                                                        $url = Yii::$app->urlManager->createUrl(['/cp/come/view','id'=>$d->id]);
                                                        return Html::a($d->code,$url);
                                                    },
                                                    'format'=>'raw',
                                                ],
                                                'date',
                                                'nakladnoy',
                                                [
                                                    'attribute'=>'price',
                                                    'value'=>function($d){
                                                        return $d->price .' so`m';
                                                    }
                                                ],
                                                //'register_id',
                                                [
                                                    'attribute'=>'register_id',
                                                    'value'=>function($d){
                                                        return $d->register->name;
                                                    },
                                                    'filter'=>\yii\helpers\ArrayHelper::map(\common\models\User::find()->where(['status'=>1])->all(),'id','name'),
                                                ],
                                            ],
                                        ]); ?>
                                </div>
                                <div class="tab-pane fade" id="profile2" role="tabpanel"  style="padding-top:20px;">
                                    <?= \yii\grid\GridView::widget([
                                        'dataProvider' => $sdataProvider,
                                        'filterModel' => $ssearchModel,
                                        'columns' => [
                                            ['class' => 'yii\grid\SerialColumn'],

//                                            'id',
//                                            'suppler_id',
                                            'date',
                                            'price',
//                                            'payment_id',
                                            [
                                                'attribute'=>'payment_id',
                                                'value'=>function($d){
                                                    return $d->payment->name;
                                                },
                                                'filter'=>\yii\helpers\ArrayHelper::map(\common\models\Payment::find()->all(),'id','name'),
                                            ],
                                            //'status',
                                            //'register_id',
                                            [
                                                'attribute'=>'register_id',
                                                'value'=>function($d){
                                                    return $d->register->name;
                                                },
                                                'filter'=>\yii\helpers\ArrayHelper::map(\common\models\User::find()->where(['status'=>1])->all(),'id','name'),
                                            ],
                                            //'modify_id',
                                            //'created',
                                            //'updated',
                                        ],
                                    ]); ?>

                                </div>
                                <div class="tab-pane fade" id="contact2" role="tabpanel"  style="padding-top:20px;">
                                    <?= \yii\grid\GridView::widget([
                                        'dataProvider' => $dataProviderReturn,
                                        'filterModel' => $searchModelReturn,
                                        'columns' => [
                                            ['class' => 'yii\grid\SerialColumn'],

                                            [
                                                'attribute' => 'code',
                                                'value'=>function($d){
                                                    $url = \yii\helpers\Url::toRoute(['/cp/suppler-return/view','id'=>$d->id]);
                                                    return Html::a($d->code,$url);
                                                },
                                                'format'=>'raw'
                                            ],
                                            'date',
                                            'price',
                                            'comment:ntext',
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
