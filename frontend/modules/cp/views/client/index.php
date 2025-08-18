<?php

use common\models\Client;
use common\models\ClientType;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\ClientSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Mijozlar ro\'yhati';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-index">


    <div class="card">
        <div class="card-body">
            <p>
                <button class="btn btn-success md-btncreate" value="<?= Yii::$app->urlManager->createUrl(['/cp/client/create'])?>" type="button">Mijoz qo'shish</button>
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
                        'value'=>function($d){
                            $url = Url::to(['client/view','id'=>$d->id]);
                            return Html::a($d->name,$url);
                        }
                    ],
                    'phone',
//            'phone_two',
//            'type_id',
                    [
                        'attribute'=>'type_id',
                        'value'=>function($d){
                            return $d->type->name;
                        },
                        'filter'=>\yii\helpers\ArrayHelper::map(ClientType::find()->all(),'id','name'),
                    ],
                    //'comment',
                    'balans',
                    //'credit',
                    //'debt',
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
                ],
            ]); ?>
        </div>
    </div>


</div>
