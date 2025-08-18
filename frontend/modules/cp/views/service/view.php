<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Goods $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Xizmatlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="goods-view">

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">

                    <p>
                        <button class="btn btn-primary md-btnupdate" value="<?= Yii::$app->urlManager->createUrl(['/cp/service/update','id'=>$model->id])?>">O`zgartirish</button>
                        <?= Html::a('O`chirish', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
//                            'type',
                            'name',
                            'barcode',
//                            'group_id',
                            [
                                'attribute'=>'group_id',
                                'value'=>function($model){
                                    return $model->group->name;
                                }
                            ],
//                            'unit_id',
                            [
                                'attribute'=>'unit_id',
                                'value'=>function($model){
                                    return $model->unit->name;
                                }
                            ],
//                            'image',
//                            'status',
                            'come',
                            'sale',
                            'remainder',
                            [
                                'attribute'=>'status',
                                'value'=>function($model){
                                    return Yii::$app->params['status'][$model->status];
                                }
                            ],
                            'created',
                            'updated',

                            [
                                'attribute'=>'image',
                                'value'=>function($model){
                                    if($model->image != 'default/nophoto.png'){
                                        return "<img src='/upload/goods/tmp/{$model->image}' alt='{$model->image}' style='width: 100px'>";
                                    }else{
                                        return "<img src='/upload/{$model->image}' alt='{$model->image}' style='width: 100px'>";
                                    }
                                },
                                'format'=>'raw',
                            ],
                        ],
                    ]) ?>
                </div>


            </div>
        </div>
    </div>

</div>
