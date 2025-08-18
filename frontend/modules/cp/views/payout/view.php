<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Payout $model */

$this->title = $model->wallet->name;
$this->params['breadcrumbs'][] = ['label' => 'Pul chiqarishlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="payout-view">


    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="h4 text-blue mb-20">Mijoz ma'lumotlari</h5>
                    <?= DetailView::widget([
                        'model' => $model->client,
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
                <div class="col-md-6">
                    <h5 class="h4 text-blue mb-20">Depozit ma'lumotlari</h5>
                    <?php if($model->state == 'NEW'){?>
                        <p>
                            <?= Html::a('Depozitni tasdiqlash', ['ok', 'id' => $model->id], ['class' => 'btn btn-primary','data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],]) ?>
                        </p>

                    <?php }?>

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
//                            'client_id',
                            'code',
//                            'wallet_id',
                            'price',
                            [
                                'attribute'=>'wallet_id',
                                'value'=>function($d){
                                    return $d->wallet->number.'<br>'.$d->wallet->name;
                                },
                                'format'=>'raw',
                            ],
//                            'card_id',
                            [
                                'attribute'=>'card_id',
                                'value'=>function($d){
                                    return $d->card->number;
                                }
                            ],
                            'state',
//                            'description:ntext',
//                            'approved_id',
                            [
                                'attribute'=>'approved_id',
                                'value'=>function($d){
                                    return @$d->approved->name;
                                }
                            ],
//                            'status',
                            'created',
                            'updated',
                        ],
                    ]) ?>


                </div>
            </div>
        </div>
    </div>

</div>
