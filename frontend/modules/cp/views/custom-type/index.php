<?php

use common\models\CustomType;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\CustomTypeSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Boshqa sozmalar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="custom-type-index">

    <div class="card">
        <div class="card-body">


            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

//                    'id',
//                    'name',
                    [
                        'attribute'=>'name',
                        'value'=>function($model){
                            $url = Url::to(['/cp/custom-type/setting', 'id' => $model->id]);
                            return Html::a($model->name, $url);
                        },
                        'format'=>'raw',
                    ],
                ],
            ]); ?>
        </div>
    </div>


</div>
