<?php

use common\models\ProductGroup;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\ProductGroupSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Xizmat turlari';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-group-index">
    <div class="card">
        <div class="card-body">
            
    <p>
         <button class="btn btn-success md-btncreate" value="<?= Url::to(['create']) ?>" type="button">Xizmat turi qo'shish</button>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'name',
            [
                'attribute'=>'image',
                'value'=>function($d){
                    return Html::img('/upload/'.$d->image,['style'=>'height:100px;']);
                },
                'format'=>'raw',
            ],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($model) {
                    $url = Yii::$app->urlManager->createUrl(['/cp/product-group/update','id'=>$model->id]);
                    return Html::button($model->name,['class'=>'btn btn-link md-btnupdate','value'=>$url]);
                }
            ],
            [
                'attribute'=>'status',
                'value'=>function($d){
                    return Yii::$app->params['status'][$d->status];
                },
                'filter'=>Yii::$app->params['status'],
            ],
//            'type',
            'created',
//            'updated',
            [
                'label'=>'',
                'value'=>function($d){
                    $url = Yii::$app->urlManager->createUrl(['/cp/product-group/delete','id'=>$d->id]);
                    return Html::a('<span class="fa fa-trash"></span>',$url,['class'=>'btn btn-danger','data-method'=>'post','data-confirm'=>'Siz rostdan ham ushbu elementni o`chirmoqchimisiz?']);
                },
                'format'=>'raw',
            ],
            //'register_id',
            //'modify_id',
        ],
    ]); ?>


        </div>
    </div>
</div>
