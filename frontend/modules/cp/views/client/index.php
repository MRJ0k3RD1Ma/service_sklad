<?php

use common\models\Client;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\ClientSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Mijozlar ro`yhati';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-index">




    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="card">
        <div class="card-body">

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

//                    'id',
//                    'name',
                    [
                        'attribute'=>'name',
                        'value'=>function($d){
                            $url = Yii::$app->urlManager->createUrl(['/cp/client/view','id'=>$d->id]);
                            return Html::a($d->name,$url);
                        },
                        'format'=>'raw'
                    ],
//                    'payout',
                    [
                        'attribute'=>'payout',
                        'value'=>function($d){
                            return $d->payout.' marta';
                        }
                    ],
//                    'deposit',
                    [
                        'attribute'=>'deposit',
                        'value'=>function($d){
                            return $d->deposit.' so`m';
                        }
                    ],
                    'chat_id',
//                    'status',
                    'created',
                    'updated',
                ],
            ]); ?>
        </div>
    </div>


</div>
