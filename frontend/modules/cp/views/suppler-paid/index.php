<?php

use common\models\SupplerPaid;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\SupplerPaidSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Suppler Paids';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suppler-paid-index">


    <div class="card">
        <div class="card-body">
            <p>
                <button class="btn btn-success md-btnupdate" value="<?= Yii::$app->urlManager->createUrl(['/cp/suppler-paid/create'])?>">To'lov qilish</button>

            </p>

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'suppler_id',
                    'date',
                    [
                        'attribute'=>'suppler_id',
                        'value'=>function($d){
                            $url = Yii::$app->urlManager->createUrl(['/cp/suppler/view', 'id' => $d->suppler_id]);
                            return Html::a($d->suppler->name, $url);
                        },
                        'format'=>'raw',
                        'filter'=>\yii\helpers\ArrayHelper::map(\common\models\Suppler::find()->all(), 'id', 'name')
                    ],
                    'price',
//            'payment_id',
                    [
                        'attribute'=>'payment_id',
                        'value'=>function($d){
                            return $d->payment->name;
                        },
                        'filter'=>\yii\helpers\ArrayHelper::map(\common\models\Payment::find()->all(), 'id', 'name')
                    ],
                    //'status',
//            'register_id',
                    [
                        'attribute'=>'register_id',
                        'value'=>function($d){
                            return $d->register->name;
                        },
                        'filter'=>\yii\helpers\ArrayHelper::map(\common\models\User::find()->all(), 'id', 'name')
                    ],
                    //'modify_id',
                    'created',
                    //'updated',
                ],
            ]); ?>
        </div>
    </div>


</div>
