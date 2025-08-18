<?php

use common\models\Visit;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\VisitSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Ta`mirlashlar ro`yhati';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visit-index">

    <div class="card">
        <div class="card-body">

            <p>
                <?= Html::a('Yangi moshina qo`shish', ['create'], ['class' => 'btn btn-success']) ?>
            </p>


        </div>
    </div>

    <style>
        .numberBlock {
            margin-bottom: 10px;
            float:left;
        }

        .numberBlockInner {
            padding: 12px 16px;
            border: 1px solid #ccc;
            border-radius: 15px;
            background: #fff;
        }

        .numberImg {
            position: relative;
            border: 4px solid #353535;
            border-radius: 6px;
            padding-left: 5px;
            padding-right: 9px;
            margin-bottom: 20px;
            margin-top: 10px;
        }

        .numberImg:before {
            left: 3px;
        }


        .numberImg p {
            display: inline-block;
            height: 100%;
            margin-bottom: 0px;
            font-size: 33px;
            font-family: roadNumbers;
            font-weight: bold;
            color: #2E2E2E;
            line-height: 1.2;
        }

        p.numberImgNum {
            width: 70%;
            text-align: left;
            letter-spacing: 2px;
            /* padding-left: 10px; */
            padding-left: 0px;
            background: url(../img/numberBlockBG.png) no-repeat right center;
            background-size: 11% 65%;
        }

        .numberImg p {
            display: inline-block;
            height: 100%;
            margin-bottom: 0px;
            font-size: 33px;
            font-family: roadNumbers;
            font-weight: bold;
            color: #2E2E2E;
            line-height: 1.2;
        }

        .numberImg:after {
            right: 3px;
        }

        .numberInfoString {
            color: #5d5d5d;
            clear: both;
            padding-top: 5px;
            border-top: solid 1px #ccc;
        }

        .numberInfoString p {
            font-size: 13px;
        }

        p.numberInfo {
            padding-left: 5px;
        }

        .numberInfo {
            -webkit-transition: all .5s ease;
            transition: all .5s ease;
        }

        .left {
            float: left;
        }

        .numberInfo {
            position: relative;
            margin-bottom: 0px;
        }

        .right {
            float: right;
        }

        p.numberInfo.left .title {
            text-align: left;
        }

        p.numberInfo .title {
            font-size: 10px;
            color: #989898;
            display: block;
            text-decoration: none;
        }

        p.numberInfo .element {
            font-size: 11px;
            font-weight: bold;
        }

        .numberImgNum {
            text-align: center !important;
        }

        .status {
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            text-align: center;
        }

        /* Ranglar har bir holat uchun */
        .NEW {
            background-color: #007bff; /* Ko'k */
        }

        .RUNNING {
            background-color: #ffc107; /* Sariq */
            color: black; /* Matn qora */
        }

        .COMPLETED {
            background-color: #28a745; /* Yashil */
        }
    </style>
    <div class="row">
        <div class="col-12">
            <?= \yii\widgets\ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('_visit_item', ['model' => $model]);
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


</div>
