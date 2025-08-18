<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Come $model */

$this->title = $model->suppler->name.' dan kelgan mahsulotlar';
$this->params['breadcrumbs'][] = ['label' => 'Skladga qabul qilingan mahsulotlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="come-view">


    <div class="card">
        <div class="card-body">
            <p>
                <?= Html::a('Ushbu mahsulotlarni o`chirish', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
                <button class="btn btn-success md-btncreate" value="<?= Yii::$app->urlManager->createUrl(['/cp/come/create','come_id'=>$model->id])?>" type="button">Mahsulot qo'shish</button>
            </p>

            <div class="row">
                <div class="col-md-4">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [

//                    'id',
//                    'code',
                            'code',
                            'date',
//                    'code_id',
                            'nakladnoy',
                            //'suppler_id',
                            [
                                'attribute'=>'suppler_id',
                                'value'=>function($d){
                                    return $d->suppler->name;
                                },
                                'filter'=>\yii\helpers\ArrayHelper::map(\common\models\Suppler::find()->where(['status'=>1])->all(),'id','name'),

                            ],
//                    'price',
                            [
                                'attribute'=>'price',
                                'value'=>function($d){
                                    return $d->price .' so`m';
                                }
                            ],
                            'comment:ntext',
                            //'register_id',
                            [
                                'attribute'=>'register_id',
                                'value'=>function ($d) {
                                    return $d->register->name;
                                }
                            ],
                            //'status',
                            [
                                'attribute'=>'status',
                                'value'=>function($d){
                                    return Yii::$app->params['status'][$d->status];
                                }
                            ],
                            'created',
                            'updated',
                        ],
                    ]) ?>
                </div>

                <div class="col-md-8 table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nomi</th>
                            <th>Kodi</th>
                            <th>Soni</th>
                            <th>Narxi</th>
                            <th>Umumiy narx</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($model->comeProducts as $key=>$item):
                            $goods = $item->goods;
                            ?>
                            <tr>
                                <td><?= $key+1?></td>
                                <td><?= $goods->name?></td>
                                <td><?= $goods->barcode?></td>
                                <td><?= $item->cnt?></td>
                                <td><?= $item->price?></td>
                                <td><?= $item->cnt_price?></td>
                                <td><a class="btn btn-danger" data-confirm="Siz rostdan ham ushbu mahsulotni o`chirmoqchimisiz?" href="<?= Yii::$app->urlManager->createUrl(['/cp/come/deletepro','id'=>$item->id,'come_id'=>$item->come_id,'goods_id'=>$item->goods_id])?>"><span class="fa fa-trash"></span></a></td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

</div>
