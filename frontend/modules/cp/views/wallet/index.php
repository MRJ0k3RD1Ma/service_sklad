<?php

use common\models\Wallet;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\WalletSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Walletlar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wallet-index">


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
                        'attribute'=>'client_id',
                        'value'=>function($d){
                            $url = Yii::$app->urlManager->createUrl(['cp/client/view','id'=>$d->client_id]);
                            return Html::a($d->client->name,$url);
                        },
                        'format'=>'raw',
                    ],
                    'number',
                    'valyuta',
                    'name',
                    //'status',
                    //'created',
                    //'updated',
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, Wallet $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ],
                ],
            ]); ?>


        </div>
    </div>
</div>
