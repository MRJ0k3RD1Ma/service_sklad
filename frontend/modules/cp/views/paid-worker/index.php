<?php

use common\models\PaidWorker;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\PaidWorkerSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Paid Workers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paid-worker-index">
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

            'id',
            'worker_id',
            'date',
            'price',
            'description:ntext',
            //'payment_id',
            //'status',
            //'created',
            //'updated',
            //'register_id',
            //'modify_id',
            //'sale_id',
        ],
    ]); ?>


        </div>
    </div>
</div>
