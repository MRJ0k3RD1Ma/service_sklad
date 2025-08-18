<?php

use common\models\Card;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\CardSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Kartalar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card-index">

    <div class="card">
        <div class="card-body">


            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute'=>'client_id',
                        'value'=>function($d){
                            $url = Yii::$app->urlManager->createUrl(['cp/client/view','id'=>$d->client_id]);
                            return Html::a($d->client->name,$url);
                        },
                        'format'=>'raw',
                    ],
                    'number',

                    //'status',
                    'created',
                    'updated',

                ],
            ]); ?>
        </div>
    </div>


</div>
