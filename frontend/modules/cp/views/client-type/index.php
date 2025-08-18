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
                <button class="btn btn-success md-btncreate" value="<?= Yii::$app->urlManager->createUrl(['/cp/client-type/create'])?>" type="button">Mijoz turi qo'shish</button>
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
                        'attribute' => 'name',
                        'format'=>'raw',
                        'value' => function($model){
                            $url = Url::to(['client-type/update', 'id' => $model->id]);
                            return "<button class='btn btn-link md-btnupdate' type='button' value='{$url}'>{$model->name}</button>";
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'value' => function($model){
                            return Yii::$app->params['status'][$model->status];
                        },
                        'filter' => Yii::$app->params['status']
                    ]
                ],
            ]); ?>

        </div>
    </div>

</div>


