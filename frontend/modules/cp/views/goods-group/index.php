<?php

use common\models\GoodsGroup;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\GoodsGroupSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Mahsulot turlari';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-group-index">
    <div class="card">
        <div class="card-body">


            <p>
                <button class="btn btn-success md-btncreate" value="<?= Yii::$app->urlManager->createUrl(['/cp/goods-group/create'])?>" type="button">Mahsulot turi qo'shish</button>
            </p>

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

//                    'id',

//                    'name',
                    [
                        'attribute'=>'name',
                        'value'=>function($model){
                            $url = Url::toRoute(['/cp/goods-group/view', 'id' => $model->id]);
                            return "<a href='{$url}'>{$model->name}</a>";
                        },
                        'format'=>'raw'
                    ],
//                    'status',
                    [
                        'attribute'=>'status',
                        'value'=>function($model){
                            return Yii::$app->params['status'][$model->status];
                        },
                        'filter'=>Yii::$app->params['status']
                    ],
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
//                    'image',
//                    'type',
                ],
            ]); ?>
        </div>
    </div>


</div>
