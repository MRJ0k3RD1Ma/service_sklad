<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Sale $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sotuvlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="sale-view">

    <div class="card">
        <div class="card-body">
            <p>
                <?= Html::a('O`chirish', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Siz rostdan ham bu ma`lumotni o`chirmoqchimisiz?',
                        'method' => 'post',
                    ],
                ]) ?>
                <?php if($model->client and $model->credit > 0){?>
                <button class="btn btn-info md-btncreate" value="<?= Yii::$app->urlManager->createUrl(['/cp/sale/paid','id'=>$model->id])?>"><span class="fa fa-money"></span> To'lovni qabul qilish</button>
                <?php }?>
                <button class='btn btn-primary printbtn' value='<?= Yii::$app->urlManager->createUrl(['/cp/gen/saledprint','id' => $model->id])?>'><span class='fa fa-print'></span> Qog'ozga chiqarish</button>
                <?php
                $this->registerJs("
    $('.printbtn').click(function(){
        let url = $(this).val();
        window.open(url, '_blank', 'width=600,height=800,toolbar=0,location=0,menubar=0');
        return false;
    })
")
                ?>

            </p>
            <div class="row">
                <div class="col-md-3">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
//                    'user_id',
                            'price',
                            'status',
                            'created',
                            'updated',
                            'credit',
                            'debt',
                            'code',

                            [
                                'label'=>'Mijoz',
                                'value'=>function($d){
                                    $client = $d->client;
                                    if($client == null){
                                        return null;
                                    }
                                    $client = $client[0];
                                    $url = Yii::$app->urlManager->createUrl(['/cp/client/view','id'=>$client->id]);
                                    return Html::a($client->name.' - '.$client->phone,$url);
                                },
                                'format'=>'raw',
                            ],
                            [
                                'label'=>'To\'lov holati',
                                'value'=>function($d){
                                    if($d->saleCredit == null){
                                        return 'Joyida to\'langan';
                                    }
                                    return 'Qarzga berilgan';
                                },
                                'format'=>'raw',
                            ],
                            [
                                'label'=>'Qarz to`lov sanasi',
                                'value'=>function($d){
                                    if($d->saleCredit == null){
                                        return "To'langan";
                                    }
                                    return $d->saleCredit->call_date;
                                }
                            ],
//                    'code_id',
                            [
                                'attribute' => 'user_id',
                                'value'=>function($d){
                                    return $d->user->name;
                                }
                            ],

                        ],
                    ]) ?>

                </div>


                <div class="col-md-9">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Maxsulot</th>
                            <th>Narxi</th>
                            <th>Soni</th>
                            <th>Summasi</th>
                            <th>Bajaruvchi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($model->product as $key => $item): ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><button class="md-btnupdate btn btn-link" value="<?= Yii::$app->urlManager->createUrl(['/cp/sale/updatepro','id'=>$item->id])?>"><?= $item->product->name ?></button></td>
                                <td><?= $item->price ?></td>
                                <td><?= $item->cnt ?></td>
                                <td><?= $item->cnt_price ?></td>
                                <td><?= $item->user->name ?></td>
                                <td><a href="<?= Yii::$app->urlManager->createUrl(['/cp/sale/deletepro/','id'=>$item->id])?>" class="btn btn-danger" data-confirm="Siz rostdan ham ushbu elementni o'chirmoqchisimi?"><span class="fa fa-trash"></span></a></td>

                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
