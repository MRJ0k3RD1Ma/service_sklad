<?php

use common\models\FornitureWallType;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\FornitureWallTypeSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Devor turlari';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forniture-wall-type-index">
    <div class="card">
        <div class="card-body">
            <p>
                <button class="btn btn-success md-btncreate" value="<?= Yii::$app->urlManager->createUrl(['/cp/forniture-wall-type/create'])?>" type="button">Devor turi qo'shish</button>
            </p>



            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

//            'id',
                    'name',

//                    'status',
                    [
                        'attribute'=>'status',
                        'value'=>function($d){
                            return Yii::$app->params['status'][$d->status];
                        },
                        'filter'=>Yii::$app->params['status'],
                    ],
                    'created',
                    'updated',
                    [
                        'label'=>'',
                        'value'=>function($d){
                            $url = Yii::$app->urlManager->createUrl(['/cp/forniture-wall-type/update', 'id'=>$d->id]);
                            $url_delete = Yii::$app->urlManager->createUrl(['/cp/forniture-wall-type/delete', 'id'=>$d->id]);
                            return Html::button('<i class="bi bi-pencil-square"></i>', [
                                    'class'=>'btn btn-primary md-btnupdate',
                                    'value'=>$url,
                                    'type'=>'button',
                                ]).' '.Html::a('<i class="bi bi-trash"></i>',
                                    $url_delete,
                                    [
                                        'class'=>'btn btn-danger',
                                        'data' => [
                                            'confirm' => 'O`chirishni tasdiqlaysizmi?',
                                            'method' => 'post',
                                        ],
                                    ]);
                        },
                        'format'=>'raw',
                    ],
                ],
            ]); ?>
        </div>
    </div>


</div>
