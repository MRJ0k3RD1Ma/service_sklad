<?php

use common\models\Visit;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\VisitSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tashriflar ro\'yhati';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visit-index">

    <div class="card">
        <div class="card-body">


            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'date',
                    [
                        'attribute'=>'date',
                        'value'=>function($d){
                            $url = Yii::$app->urlManager->createUrl(['/cp/visit/view','id'=>$d->id]);
                            return Html::a($d->date,$url);
                        },
                        'format'=>'raw'
                    ],
//            'client_id',
                    [
                        'attribute'=>'client_name',
                        'value'=>function($d){
                            $url = Yii::$app->urlManager->createUrl(['/cp/client/view','id'=>$d->client_id]);
                            return Html::a($d->client->name,$url);
                        },
                        'format'=>'raw'
                    ],
                    [
                        'attribute'=>'car_number',
                        'value'=>function($d){
                            return $d->car->model.' '.$d->car->number;
                        }
                    ],
                    'price',
                    'debt',
                    'credit',
                    [
                        'attribute'=>'state',
                        'value'=>function($d){
                            return Yii::$app->params['service.state'][$d->state];
                        },
                        'filter'=>Yii::$app->params['service.state']
                    ],
                    [
                        'attribute'=>'user_id',
                        'value'=>function($d){
                            return $d->user->name;
                        },
                        'filter'=>\yii\helpers\ArrayHelper::map(\common\models\User::find()->where(['status'=>1])->all(),'id','name')
                    ],
//            'car_id',
                ],
            ]); ?>
        </div>
    </div>


</div>
