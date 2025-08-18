<?php

use common\models\Payout;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\PayoutSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Pul chiqarishlar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payout-index">

    <div class="card">
        <div class="card-body">

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'client_id',
                    [
                        'attribute'=>'wallet_id',
                        'value'=>function($d){
                            $url = Yii::$app->urlManager->createUrl(['/cp/payout/view','id'=>$d->id]);
                            return Html::a($d->wallet->number,Url::to($url));
                        },
                        'format'=>'raw',
                    ],
                    [
                        'attribute'=>'client_id',
                        'value'=>function($d){
                            $url = Yii::$app->urlManager->createUrl(['/cp/client/view','id'=>$d->client_id]);
                            return Html::a($d->client->name,$url);
                        },
                        'filter'=>ArrayHelper::map(\common\models\Client::find()->all(),'id','name'),
                        'format'=>'raw',
                    ],
                    'code',
//            'wallet_id',

//            'card_id',
                    [
                        'attribute'=>'card_id',
                        'value'=>function($d){
                            return $d->card->number;
                        }
                    ],
                    'price',
//                    'state',
                    [
                        'attribute'=>'state',
                        'value'=>'state',
                        'filter'=>Yii::$app->params['payout.state']
                    ],
                    //'description:ntext',
//            'approved_id',
                    [
                        'attribute'=>'approved_id',
                        'value'=>function($d){
                            return @$d->approved->name;
                        }
                    ],
                    //'status',
                    //'created',
                    'updated',
                ],
            ]); ?>
        </div>
    </div>


</div>
