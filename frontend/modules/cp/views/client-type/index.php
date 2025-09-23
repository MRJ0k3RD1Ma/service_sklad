<?php

use common\models\ClientType;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\ClientTypeSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Mijoz turlari';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-type-index">
    <div class="card">
        <div class="card-body">
            
    <p>
         <button class="btn btn-success md-btncreate" value="<?= Url::to(['create']) ?>" type="button">Mijoz turi qo'shish</button>
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
                    $url = Yii::$app->urlManager->createUrl(['/cp/client-type/update','id'=>$d->id]);
                    return Html::button($d->name,['value'=>$url,'class'=>'md-btnupdate btn btn-link']);
                },
                'format'=>'raw',
            ],
//            'status',
            [
                'attribute'=>'status',
                'value'=>function($model){
                    return Yii::$app->params['status'][$model->status];
                },
                'filter' => Yii::$app->params['status']
            ],
            'created',
            'updated',
            [
                'label'=>'',
                'value'=>function($d){
                    $url = Yii::$app->urlManager->createUrl(['/cp/client-type/delete','id'=>$d->id]);
                    return Html::a('<span class="fa fa-trash"></span>',$url,['class'=>'btn btn-danger btn-delete','data-confirm'=>'Siz rostdan ham ushbu elementni o`chirmoqchimisiz?','data-method'=>'POST',]);
                },
                'format'=>'raw'
            ],
            //'register_id',
            //'modify_id',
        ],
    ]); ?>


        </div>
    </div>
</div>
