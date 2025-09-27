<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

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
                    <p>1. To'lovlar</p>
                    <p>2. Barcha ishlari</p>
                </div>
            </div>

        </div>
    </div>
</div>
