<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

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
                    <p>1. Salelar ro'yhati</p>
                </div>
            </div>

        </div>
    </div>
</div>
