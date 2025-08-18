<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

use yii\helpers\Url;
use yii\grid\ActionColumn;

/** @var yii\web\View $this */
/** @var common\models\Client $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Mijozlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="client-view">


    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <h5 class="h4 text-blue mb-20" style="margin-top:20px;">Mijoz ma'lumotlari</h5>
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'name',
                            'chat_id',
                            'status',
//                            'payout',
//                            'deposit',
                            'created',
                            'updated',
                        ],
                    ]) ?>
                </div>
                <div class="col-md-8">
                    <div class="pd-20 card-box">
                        <h5 class="h4 text-blue mb-20">Mijoz bilan munosabatlar</h5>
                        <div class="tab">
                            <ul class="nav nav-tabs customtab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#deposit" role="tab" aria-selected="true">Depozitlar</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#payout" role="tab" aria-selected="false">Pul chiqarishlar</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#card" role="tab" aria-selected="false">Kartalar</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#wallet" role="tab" aria-selected="false">Walletlar</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="deposit" role="tabpanel" style="padding-top:20px;">

                                    <?= GridView::widget([
                                        'dataProvider' => $dataDepositProvider,
                                        'filterModel' => $searchDepositModel,
                                        'columns' => [
                                            ['class' => 'yii\grid\SerialColumn'],

//                                            'id',
                                            'uuid',
                                            'price',
//                                            'client_id',
//                                            'payment_id',
                                            //'verify_id',
//                                            'state',
                                            [
                                                'attribute'=>'state',
                                                'value'=>function($d){
                                                    return $d->state;
                                                },
                                                'filter'=>Yii::$app->params['deposit.state']
                                            ],
                                            //'status',
                                            'created',
                                            //'updated',
                                            //'merchant_trans_id',
                                            //'is_approved',
//                                            'wallet_id',
                                            [
                                                'attribute'=>'wallet_id',
                                                'value'=>function($d){
                                                    return $d->wallet->number;
                                                }
                                            ],
                                        ],
                                    ]); ?>
                                </div>
                                <div class="tab-pane fade" id="payout" role="tabpanel" style="padding-top:20px;">

                                    <?= GridView::widget([
                                        'dataProvider' => $dataPayoutProvider,
                                        'filterModel' => $searchPayoutModel,
                                        'columns' => [
                                            ['class' => 'yii\grid\SerialColumn'],

//                                            'id',
//                                            'client_id',
                                            'code',
//                                            'wallet_id',
                                            [
                                                'attribute'=>'wallet_id',
                                                'value'=>function($d){
                                                    return $d->wallet->number;
                                                }
                                            ],
                                            [
                                                'attribute'=>'card_id',
                                                'value'=>function($d){
                                                    return $d->card->number;
                                                }
                                            ],
//                                            'card_id',
//                                            'state',
                                            [
                                                'attribute'=>'state',
                                                'value'=>function($d){
                                                    return $d->state;
                                                },
                                                'filter'=>Yii::$app->params['payout.state']
                                            ],
//                                            'description:ntext',
//                                            'approved_id',
                                            [
                                                'attribute'=>'approved_id',
                                                'value'=>function($d){
                                                    return @$d->approved->name;
                                                },
                                                'filter'=>\yii\helpers\ArrayHelper::map(\common\models\User::find()->where(['status'=>1])->all(),'id','name'),
                                            ],
                                            //'status',
                                            //'created',
                                            'updated',

                                        ],
                                    ]); ?>
                                </div>

                                <div class="tab-pane fade" id="card" role="tabpanel" style="padding-top:20px;">
                                    <?= GridView::widget([
                                        'dataProvider' => $dataCardProvider,
                                        'filterModel' => $searchCardModel,
                                        'columns' => [

                                            ['class' => 'yii\grid\SerialColumn'],
                                            'number',
                                            'created',
                                        ]
                                    ])?>
                                </div>
                                <div class="tab-pane fade" id="wallet" role="tabpanel" style="padding-top:20px;">
                                    <?= GridView::widget([
                                        'dataProvider' => $dataWalletProvider,
                                        'filterModel' => $searchWalletModel,
                                        'columns' => [

                                            ['class' => 'yii\grid\SerialColumn'],
                                            'number',
                                            'name',
                                            'valyuta',
                                            'created'
                                        ]
                                    ])?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
