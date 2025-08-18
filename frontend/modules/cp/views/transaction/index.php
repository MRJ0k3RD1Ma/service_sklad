<?php

use common\models\Transaction;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\TransactionSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Depozitlar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-index">

    <div class="card">
        <div class="card-body">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

//                    'id',
//                    'uuid',
//                    'client_id',
                    [
                        'attribute'=>'wallet_id',
                        'value'=>function($d){
                            $url = Yii::$app->urlManager->createUrl(['/cp/transaction/view','id'=>$d->id]);
                            return Html::a($d->wallet->number,$url);
                        },
                        'format'=>'raw',
                    ],
                    [
                        'attribute'=>'client_id',
                        'value'=>function($d){
                            $url = Yii::$app->urlManager->createUrl(['/cp/client/view','id'=>$d->client_id]);
                            return Html::a($d->client->name,$url);
                        },
                        'format'=>'raw',
                        'filter'=>\yii\helpers\ArrayHelper::map(\common\models\Client::find()->all(),'id','name'),
                    ],
                    'price',
//                    'payment_id',
                    //'verify_id',
//                    'state',

                    [
                        'attribute'=>'state',
                        'value'=>function($d){
                            return $d->state;
                        },
                        'format'=>'raw',
                        'filter'=>Yii::$app->params['deposit.state'],
                    ],
                    //'status',
                    'created',
                    //'updated',
                    //'merchant_trans_id',
                    //'is_approved',
                    //'wallet_id',
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, Transaction $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ],
                ],
            ]); ?>
        </div>
    </div>


</div>
