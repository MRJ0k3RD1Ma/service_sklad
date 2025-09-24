<?php

use common\models\ProductUnit;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\ProductUnitSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Xizmat birliklari';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-unit-index">
    <div class="card">
        <div class="card-body">
            
    <p>
         <button class="btn btn-success md-btncreate" value="<?= Url::to(['create']) ?>" type="button">Birlik qo'shish</button>
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
                'attribute'=>'name',
                'value'=>function($d){
                    $url = Yii::$app->urlManager->createUrl(['cp/product-unit/update','id'=>$d->id]);
                    return Html::button($d->name,['class'=>'btn btn-link md-btnupdate','value'=>$url]);
                },
                'format'=>'raw',
            ],
//            'status',
            [
                'attribute'=>'status',
                'value'=>function($d){
                    return Yii::$app->params['status'][$d->status];
                },
                'filter'=>Yii::$app->params['status'],
            ],
            'created',
            'updated',
            //'register_id',
            //'modify_id',
            [
                'label'=>'',
                'value'=>function($d){
                    $url = Yii::$app->urlManager->createUrl(['/cp/product-unit/delete','id'=>$d->id]);
                    return Html::a('<span class="fa fa-trash"></span>',$url,['class'=>'btn btn-danger','data-confirm'=>'Siz rostdan ham ushbu elementni o`chirmoqchimisiz?','data-method'=>'post']);
                },
                'format'=>'raw',
            ],
        ],
    ]); ?>


        </div>
    </div>
</div>
