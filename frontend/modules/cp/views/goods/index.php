<?php

use common\models\Goods;
use common\models\GoodsGroup;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\GoodsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Mahsulotlar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-index">


    <div class="card">
        <div class="card-body">
            <p>
                <button class="btn btn-success md-btncreate" value="<?= Yii::$app->urlManager->createUrl(['/cp/goods/create'])?>" type="button">Mahsulot qo'shish</button>
            </p>


            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

//                    'id',
//                    'type',

//                    'name',
                    [
                        'attribute'=>'name',
                        'value'=>function($d){
                            $url = Url::toRoute(['/cp/goods/view','id'=>$d->id]);
                            return Html::a($d->name,$url);
                        },
                        'format'=>'raw',
                    ],
                    'barcode',
//                    'group_id',
                    [
                        'attribute'=>'group_id',
                        'value'=>function($d){
                            return $d->group->name;
                        },
                        'filter'=>\yii\helpers\ArrayHelper::map(GoodsGroup::find()->where(['status'=>1,'type'=>1])->all(),'id','name'),
                    ],
//                    'unit_id',
                    [
                        'attribute'=>'unit_id',
                        'value'=>function($d){
                            return $d->unit->name;
                        },
                        'filter'=>\yii\helpers\ArrayHelper::map(\common\models\GoodsUnit::find()->all(),'id','name')
                    ],
                    'price',
                    //'updated',
                    //'come',
                    //'sale',
                    'remainder',
//                    'status',
                    [
                        'attribute'=>'status',
                        'value'=>function($d){
                            return Yii::$app->params['status'][$d->status];
                        },
                        'filter'=>Yii::$app->params['status']
                    ],
                    [
                        'attribute'=>'image',
                        'format'=>'raw',
                        'value'=>function($model){
                            if($model->image != 'default/nophoto.png'){
                                return "<img src='/upload/goods/tmp/{$model->image}' alt='{$model->image}' style='width: 100px'>";
                            }else{
                                return "<img src='/upload/{$model->image}' alt='{$model->image}' style='width: 100px'>";
                            }
                        },
                        'filter'=>false
                    ],
//                    'created',
                ],
            ]); ?>
        </div>
    </div>


</div>
