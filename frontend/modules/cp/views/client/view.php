<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Client $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="client-view">

    <div class="card">
        <div class="card-body">
            
    <p>
        <?= Html::button('O`zgartirish', ['value'=>Yii::$app->urlManager->createUrl(['/cp/client/update','id'=>$model->id]),'class' => 'btn btn-primary md-btnupdate'],) ?>
        <?= Html::a('O`chirish', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Siz rostdan ham ushbu ma`lumotni o`chirmoqchimisiz?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::button('<span class="fa fa-money"></span> To`lov qabul qilish', ['value'=>Yii::$app->urlManager->createUrl(['/cp/client/paying','id'=>$model->id]),'class' => 'btn btn-primary md-btnupdate'],) ?>

    </p>

            <div class="row">
                <div class="col-md-4">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
//                            'image',
                            [
                                'attribute'=>'image',
                                'value'=>function($d){
                                    return Html::img('/upload/'.$d->image,['style'=>'height:200px;']);
                                },
                                'format'=>'raw',
                            ],
//                            'type_id',
                            [
                                'attribute'=>'type_id',
                                'value'=>function($d){
                                    return $d->type->name;
                                }
                            ],
                            'name',
                            'phone',
                            'phone_two',
                            'comment',
                            'balance',
//                            'status',
                            [
                                'attribute'=>'status',
                                'value'=>function($d){
                                    return Yii::$app->params['status'][$d->status];
                                }
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
                    <p>1. sale ro'yhati</p>
                    <p>2. Paid ro'yhati</p>
                </div>
            </div>

        </div>
    </div>
</div>
