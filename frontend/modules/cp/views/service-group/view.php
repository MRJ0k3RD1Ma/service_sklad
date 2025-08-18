<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\GoodsGroup $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Xizmat turlari', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="goods-group-view">


    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <p>
                        <button class="btn btn-primary md-btnupdate" value="<?= Yii::$app->urlManager->createUrl(['/cp/service-group/update','id'=>$model->id])?>">O`zgartirish</button>
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
                            'name',
//                            'status',
                            [
                                'attribute'=>'status',
                                'value'=>function($model){
                                    return Yii::$app->params['status'][$model->status];
                                }
                            ],
//                            'image',
                            [
                                'attribute'=>'image',
                                'format'=>'raw',
                                'value'=>function($model){
                                    if($model->image != 'default/nophoto.png'){
                                        return "<img src='/upload/goodsgroup/tmp/{$model->image}' alt='{$model->image}' style='width: 100px'>";
                                    }else{
                                        return "<img src='/upload/{$model->image}' alt='{$model->image}' style='width: 100px'>";
                                    }
                                },
                                'filter'=>false
                            ],
//                            'type',
                        ],
                    ]) ?>
                </div>

                <div class="col-md-9 table-responsive">
                    <table class="table table-bordered table-hover">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nomi</th>
                                <th>Barcode</th>
                                <th>Qoldiq</th>
                                <th>Birlik</th>
                                <th>Status</th>
                                <th>Rasmi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($model->goods as $key=>$item):?>
                            <tr>
                                <td><?= $key?></td>
                                <td><a href="<?= Yii::$app->urlManager->createUrl(['/cp/service/view','id'=>$item->id])?>"><?= $item->name?></a></td>
                                <td><?= $item->barcode?></td>
                                <td><?= $item->remainder?></td>
                                <td><?= $item->unit->name?></td>
                                <td><?= Yii::$app->params['status'][$item->status] ?></td>
                                <?php if($item->image != 'default/nophoto.png'):?>
                                <td><img src="/upload/goods/tmp/<?=$item->image ?>" alt=""></td>
                                <?php else: ?>
                                    <td><img src="/upload/<?=$item->image ?>" alt=""></td>
                                <?php endif;?>
                            </tr>    
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>

</div>
