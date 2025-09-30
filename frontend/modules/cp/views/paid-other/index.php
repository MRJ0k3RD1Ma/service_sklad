<?php

use common\models\PaidOther;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\PaidOtherSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Boshqa to`lovlar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paid-other-index">
    <div class="card">
        <div class="card-body">
            
    <p>
         <button class="btn btn-success md-btncreate" value="<?= Url::to(['create']) ?>" type="button">To`lov qo'shish</button>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'type',
//            'paid_date',
            [
                'attribute'=>'paid_date',
                'value'=>function($model){
                    $url = Yii::$app->urlManager->createUrl(['/cp/paid-other/view','id'=>$model->id]);
                    return Html::a($model->paid_date,$url);
                },
                'format'=>'raw',
            ],
//            'price',
            [
                'attribute'=>'price',
                'value'=>function($model){
                    return number_format($model->price,2,'.',' ');
                }
            ],
//            'payment_id'
            [
                'attribute'=>'payment_id',
                'value'=>function($model){
                    return $model->payment->name;
                },
                'filter'=>\yii\helpers\ArrayHelper::map(\common\models\Payment::find()->where(['status'=>1])->all(),'id','name')
            ],
            [
                'attribute'=>'group_id',
                'value'=>function($d){
                    return $d->group->name;
                }
            ],
            [
                'attribute'=>'type',
                'value'=>function($d){
                    return Yii::$app->params['paid-other.type'][$d->type];
                },
                'filter'=>Yii::$app->params['paid-other.type'],
            ],
//            'group_id',

//            'description:ntext',
            //'payment_id',
            //'price',
            //'status',
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
            //'modify_id',
        ],
    ]); ?>


        </div>
    </div>
</div>
