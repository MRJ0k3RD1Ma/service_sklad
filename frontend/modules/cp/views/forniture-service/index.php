<?php

use common\models\FornitureService;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\FornitureServiceSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Jarayondagi buyurtmalar';
$this->params['breadcrumbs'][] = $this->title;
?>

    <p>
        <?= Html::a('Buyurtma qo`shish', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="row">
        <div class="col-12">
            <?= \yii\widgets\ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('_index_list', ['model' => $model]);
                },
                'layout' => "{summary}\n<div class='list-view-items'>{items}</div>",
                'options' => ['class' => 'list-view'],
                'itemOptions' => ['class' => 'list-item'],
            ]); ?>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12 d-flex justify-content-center">
            <?= \yii\widgets\LinkPager::widget([
                'pagination' => $dataProvider->pagination,
                'options' => ['class' => 'pagination'],
            ]) ?>
        </div>
    </div>



<style>
    .card-order {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 24px;
        max-width: 400px;
        width: 100%;
        float:left;
        margin-left:10px;
        margin-right:10px;
    }

    .card-order h2 {
        font-size: 20px;
        margin-bottom: 12px;
        color: #1f2937;
    }

    .card-order .item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .card-order .item span {
        color: #374151;
    }

    .field-name {
        font-weight: bold;
        color: #6b7280;
    }

    .field-value {
        text-align: right;
    }
</style>