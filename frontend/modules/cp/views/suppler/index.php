<?php

use common\models\Suppler;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\SupplerSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Yetkazuvchilar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suppler-index">


    <div class="card">
        <div class="card-body">
            <p>
                <button class="btn btn-success md-btncreate" value="<?= Yii::$app->urlManager->createUrl(['/cp/suppler/create'])?>" type="button">Yetkazuvchi qo'shish</button>
            </p>

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

//                    'id',
//                    'name',
                    [
                        'attribute'=>'name',
                        'value'=>function($d){
                            $url = Url::toRoute(['/cp/suppler/view','id'=>$d->id]);
                            return Html::a($d->name,$url);
                        },
                        'format'=>'raw',
                    ],
                    'phone',
//                    'phone_two',
//                    'comment',
                    //'updated',
                    'balans',
                    //'debt',
                    //'credit',
//                    'status',
                    [
                        'attribute'=>'status',
                        'value'=>function($d){
                            return Yii::$app->params['status'][$d->status];
                        },
                        'filter'=>Yii::$app->params['status'],
                    ],
                    'created',
                ],
            ]); ?>
        </div>
    </div>


</div>
