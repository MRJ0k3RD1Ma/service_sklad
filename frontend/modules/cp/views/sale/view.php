<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Sale $model */

$this->title = '#'.$model->code.' '.$model->date;
$this->params['breadcrumbs'][] = ['label' => 'Shartnomalar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="sale-view">
    <?php if($model->state == 'NEW'){?>
        <div class="pulse-wrapper">
            <div class="center-circle pulse-info"></div>
            <div class="pulse-wave pulse-wave-info"></div>
        </div>
        <span style="font-size: 24px; font-weight: bold">YANGI</span>
    <?php }?>
    <?php if($model->state == 'RUNNING'){?>
        <div class="pulse-wrapper">
            <div class="center-circle pulse-warning"></div>
            <div class="pulse-wave pulse-wave-warning"></div>
        </div>
        <span style="font-size: 24px; font-weight: bold">JARAYONDA</span>
    <?php }?>
    <?php if($model->state == 'DONE'){?>
        <div class="pulse-wrapper">
            <div class="center-circle pulse-success"></div>
            <div class="pulse-wave pulse-wave-success"></div>
        </div>
        <span style="font-size: 24px; font-weight: bold">ISH BAJARILGAN</span>
    <?php }?>
    <?php if($model->state == 'CANCELLED'){?>
        <div class="pulse-wrapper">
            <div class="center-circle pulse-danger"></div>
            <div class="pulse-wave pulse-wave-danger"></div>
        </div>
        <span style="font-size: 24px; font-weight: bold">SHARTNOMA BEKOR QILINGAN</span>
    <?php }?>
    <div class="card" style="margin-top:15px;">
        <div class="card-body">
            <?php if($model->state != 'DONE'){?>

            <p>

                <?= Html::a('O`zgartirish', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('O`chirish', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Siz rostdan ham ushbu ma`lumotni o`chirmoqchimisiz?',
                        'method' => 'post',
                    ],
                ]) ?>
                <?php if($model->state == 'NEW'){?>
                    <?= Html::a('ISHNI BOSHLASH', ['changestate', 'id' => $model->id], ['class' => 'btn btn-info','data-method'=>'post','data-confirm'=>'Siz rostdan ham ushbu shartnoma bo`yicha ish boshlamoqchimisiz?']) ?>
                <?php }elseif($model->state == 'RUNNING'){?>
                    <?= Html::button('ISH BAJARILDI (TUGATISH)', ['class' => 'btn btn-success md-btnupdate','value'=>Yii::$app->urlManager->createUrl(['/cp/sale/done','id'=>$model->id])]) ?>
                <?php }?>
                <?= Html::a('SHARTNOMANI BEKOR QILISH', ['closecontact', 'id' => $model->id], ['class' => 'btn btn-danger','data-method'=>'post','data-confirm'=>'Siz rostdan ham ushbu shartnomani bekor qilmoqchimisiz?']) ?>
            </p>
            <?php }?>

            <div class="row">
                <div class="col-md-4">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'date',
                            'code',
//                            'code_id',
//                            'client_id',
                        'price_worker',
                            'total_price_worker',
                            [
                                'attribute'=>'client_id',
                                'value'=>function($d){
                                    $url = Yii::$app->urlManager->createUrl(['/cp/client/view','id'=>$d->id]);
                                    return Html::a($d->client->name.'<br>Balans:'.$d->client->balance,$url);
                                },
                                'format'=>'raw',
                            ],
                            'product.name',
//                            'price',
                            [
                                'attribute'=>'price',
                                'value'=>function($d){
                                    return number_format($d->price,2,'.',' ');
                                }
                            ],
//                            [
//                                'attribute'=>'debt',
//                                'value'=>function($d){
//                                    return number_format($d->debt,2,'.',' ');
//                                }
//                            ],
//                            [
//                                'attribute'=>'credit',
//                                'value'=>function($d){
//                                    return number_format($d->credit,2,'.',' ');
//                                }
//                            ],
//                            'debt',
//                            'credit',
//                            'worker_id',
                            [
                                'attribute'=>'worker_id',
                                'value'=>function($d){
                                    return $d->worker->name;
                                }
                            ],
                            'state',
                            'created',
                            'updated',
//                            'register_id',
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
//                            'modify_id',
//                            'status',
                            [
                                'attribute'=>'status',
                                'value'=>function($d){
                                    return Yii::$app->params['status'][$d->status];
                                }
                            ],
                            'volume_estimated',
                            'min_volume',
                            'min_price',
                            'price_per',
                            'address',
                        ],
                    ]) ?>
                </div>
                <div class="col-md-8">
                    <h4>Mijoz bilan kelishuv ma'lumotlari</h4>
                    <table class="table table-bordered table-striped">
                        <tbody>
                        <tr>
                            <th>Xizmat nomi</th>
                            <th>Birlik uchun narx</th>
                            <th>Taxminiy hajm</th>
                            <th>Reaj hajm</th>
                            <th>Umumiy narxi</th>
                        </tr>
                        <tr>
                            <td><?= $model->product->name?></td>
                            <td><?= $model->price_per?></td>
                            <td><?= $model->volume_estimated?></td>
                            <td><?= $model->volume?></td>
                            <td><?= $model->price?></td>
                        </tr>
                        </tbody>
                    </table>
                    <hr>
                    <h4>Brigadir bilan kelishuv ma'lumotlari</h4>
                    <table class="table table-bordered table-striped">
                        <tbody>
                        <tr>
                            <th>Xizmat nomi</th>
                            <th>Birlik uchun narx</th>
                            <th>Taxminiy hajm</th>
                            <th>Reaj hajm</th>
                            <th>Umumiy narxi</th>
                        </tr>
                        <tr>
                            <td><?= $model->product->name?></td>
                            <td><?= $model->price_per?></td>
                            <td><?= $model->volume_estimated?></td>
                            <td><?= $model->volume?></td>
                            <td><?= $model->price?></td>
                        </tr>
                        </tbody>
                    </table>
                    ishchi ma'lumoti
                    <p>1. Shartnomaning qo'shimcha ma'lumotlari ro'yhati</p>
                    <p>2. Shartnomaning hisoblangan pullari haqida ma'lumotlari</p>
                    <p>2. Shartnoma loglari</p>
                    <h4>Shartnoma o'zgarishlari</h4>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="timeline mb-30">
                                <ul>
                                    <?php foreach (\common\models\SaleLog::find()->where(['sale_id'=>$model->id])->orderBy(['id'=>SORT_DESC])->all() as $item):?>
                                        <li>
                                            <div class="timeline-date" style="background-color: <?= Yii::$app->params['sale.log']['color'][$item->state]?>"><?= $item->created?></div>
                                            <div class="timeline-desc card-box">
                                                <div class="pd-20">
                                                    <h4 class="mb-10 h4">
                                                        <?= Yii::$app->params['sale.log']['text'][$item->state]?>
                                                    </h4>
                                                    <p>Tizimga kiritdi: <?= $item->register->name?></p>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endforeach;?>
                                </ul>
                            </div>
                        </div>


                </div>
            </div>

        </div>
    </div>
</div>
