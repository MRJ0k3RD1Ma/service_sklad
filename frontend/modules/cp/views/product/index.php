<?php

use common\models\Product;
use common\models\ProductGroup;
use common\models\ProductUnit;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\ProductSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Xizmatlar ro`yhati';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">
    <div class="card">
        <div class="card-body">
            
    <p>
         <button class="btn btn-success md-btncreate" value="<?= Url::to(['create']) ?>" type="button">Xizmat qo'shish</button>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'type',
//            'name',
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($model) {
                    $url = Yii::$app->urlManager->createUrl(['/cp/product/view', 'id' => $model->id]);
                    return Html::a($model->name, ['/cp/product/view', 'id' => $model->id]);
                },
            ],
//            'group_id',
            [
                'attribute'=>'group_id',
                'value'=>function($model){
                    return $model->group->name;
                },
                'filter'=>\yii\helpers\ArrayHelper::map(ProductGroup::find()->where(['status'=>1])->all(),'id','name'),
            ],
//            'unit_id',
            [
                'attribute'=>'unit_id',
                'value'=>function($model){
                    return $model->unit->name;
                },
                'filter'=>\yii\helpers\ArrayHelper::map(ProductUnit::find()->where(['status'=>1])->all(),'id','name'),
            ],
            //'image',
            'price',
            'price_worker',
            'created',
//            'status',
            [
                'attribute'=>'status',
                'value'=>function($model){
                    return Yii::$app->params['status'][$model->status];
                },
                'filter'=>Yii::$app->params['status'],
            ],
//            'updated',
            //'register_id',
            //'modify_id',
            //'min_volume',
            //'volume_price',
        ],
    ]); ?>


        </div>
    </div>
</div>
