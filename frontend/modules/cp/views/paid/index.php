<?php

use common\models\Paid;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\PaidSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tushumlar ro\'yhati';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paid-index">

    <div class="card">
        <div class="card-body">

            <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

//                    'id',
//                    'sale_id',
                    [
                        'label'=>'Mijoz',
                        'value'=>function($model){
                            if($model->client){

                                $url = Yii::$app->urlManager->createUrl(['/cp/client/view','id'=>$model->client[0]->id]);
                                return Html::a($model->client[0]->name,$url);
                            }else{
                                return "";
                            }
                        },
                        'format'=>'raw',
                    ],
                    [
                        'attribute'=>'sale_id',
                        'value'=>function($d){
                            $sale = $d->sale;
                            if($sale){
                                if($sale->type == 'SALE'){
                                    $url = Yii::$app->urlManager->createUrl(['/cp/sale/view','id'=>$sale->id]);
                                    return Html::a($sale->code,$url);
                                }else{
                                    $visit = $sale->visit;
                                    if($visit){
                                        $visit = $visit[0];
                                        $url = Yii::$app->urlManager->createUrl(['/cp/visit/view','id'=>$visit->id]);
                                        return Html::a($visit->date,$url);
                                    }else{
                                        return "";
                                    }
                                }
                            }
                            return "";
                        },
                        'format'=>'raw'
                    ],
                    'date',
                    'price',
//                    'payment_id',
                    [
                        'attribute'=>'payment_id',
                        'value'=>function($d){
                            return $d->payment->name;
                        },
                        'filter'=>\yii\helpers\ArrayHelper::map(\common\models\Payment::find()->all(),'id','name'),
                    ],
//                    'status',
                    [
                        'attribute'=>'status',
                        'value'=>function($d){
                            return Yii::$app->params['status'][$d->status];
                        },
                        'filter'=>Yii::$app->params['status'],
                    ],
                    'created',
                    //'updated',
                    //'register_id',
                    [
                        'attribute'=>'register_id',
                        'value'=>function($d){
                            return $d->register->name;
                        },
                        'filter'=>\yii\helpers\ArrayHelper::map(\common\models\User::find()->all(),'id','name'),
                    ],
                    //'modify_id',
                    //'type',
                ],
            ]); ?>
        </div>
    </div>


</div>
