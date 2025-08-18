<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Transaction $model */

$this->title = $model->wallet->name;
$this->params['breadcrumbs'][] = ['label' => 'Depozitlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="transaction-view">


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
                    <?php if($model->state == 'CHECK'){?>
                    <p>
                        <?= Html::a('Depozitni tasdiqlash', ['ok', 'id' => $model->id], ['class' => 'btn btn-primary','data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],]) ?>

                        <button class="btn btn-<?= $err['error'] == 1 ? 'success' : 'danger' ?>" disabled><?= $err['message']?></button>
                    </p>

                    <?php }?>

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'uuid',
                            'price',
                            [
                                'attribute'=>'wallet_id',
                                'value'=>function($d){
                                    return $d->wallet->number.'<br>'.$d->wallet->name;
                                },
                                'format'=>'raw',
                            ],
//                            'client_id',
//                            'payment_id',
                            'verify_id',
                            'payment_id',
                            'state',
//                            'status',
                            'created',
                            'updated',
//                            'merchant_trans_id',
//                            'is_approved',
//                            'wallet_id',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

</div>
