<?php

use common\models\ClientCar;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\ClientCarSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Mijoz mashinalari';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-car-index">


    <div class="card">
        <div class="card-body">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

//                    'id',
//                    'number',
                    [
                        'attribute'=>'number',
                        'value' => function(ClientCar $model) {
                            return Html::a($model->number, Url::to(['view', 'id' => $model->id]));
                        },
                        'format' => 'raw'
                    ],
                    'model',
//                    'client_id',
                    [
                        'attribute'=>'client_id',
                        'value' => function(ClientCar $model) {
                            return $model->client->name;
                        },
                        'filter' => \yii\helpers\ArrayHelper::map(\common\models\Client::find()->all(), 'id', 'name')
                    ],
                    'run',
                    'call_date',
                    //'ads:ntext',
                    //'status',
                    //'created',
                    //'updated',
                    'last_visit',

                ],
            ]); ?>

        </div>
    </div>

</div>
