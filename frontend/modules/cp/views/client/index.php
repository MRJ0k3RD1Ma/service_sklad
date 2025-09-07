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
    <div class="card">
        <div class="card-body">
            
    <p>
         <button class="btn btn-success md-btncreate" value="<?= Url::to(['create']) ?>" type="button">Mijoz qo'shish</button>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'image',
//            'type_id',
            'name',
            [
                'attribute' => 'type_id',
                'value' => function ($model) {
                    return $model->type->name;
                },
                'filter'=>\yii\helpers\ArrayHelper::map(\common\models\ClientType::find()->where(['status'=>1])->all(),'id','name')
            ],
            'phone',
            //'phone_two',
            //'comment',
            'balance',
//            'status',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return Yii::$app->params['status'][$model->status];
                },
                'filter'=>Yii::$app->params['status']
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
