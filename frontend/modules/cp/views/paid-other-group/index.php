<?php

use common\models\PaidOtherGroup;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\PaidOtherGroupSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Boshqa to`lov turlari';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paid-other-group-index">
    <div class="card">
        <div class="card-body">
            
    <p>
         <button class="btn btn-success md-btncreate" value="<?= Url::to(['create']) ?>" type="button">To`lov turi qo'shish</button>
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
                'format'=>'raw',
                'value'=>function($model){
                    $url = Yii::$app->urlManager->createUrl(['/cp/paid-other-group/update','id'=>$model->id]);
                    return Html::button($model->name,['value'=>$url,'class'=>'btn btn-link md-btnupdate']);
                }
            ],
//            'status',
            [
                'attribute'=>'status',
                'value'=>function($model){
                    return Yii::$app->params['status'][$model->status];
                },
                'filter'=>Yii::$app->params['status']
            ],
            'created',
            'updated',
            [
                'label'=>'',
                'value'=>function($d){
                    $url = Yii::$app->urlManager->createUrl(['/cp/paid-other-group/delete','id'=>$d->id]);
                    return Html::a('<span class="fa fa-trash"</span>',$url,['class'=>'btn btn-danger','data-method'=>'post','data-confirm'=>'Siz rostdan ham ushbu elementni o`chirmoqchimisiz?']);
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
