<?php

use common\models\Goods;
use common\models\GoodsGroup;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\GoodsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Qoldiqlar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-index">


    <div class="card">
        <div class="card-body">
            <p>
                <a href="" data-method="post" class="btn btn-info"><span class="fa fa-file-excel-o"></span> Export qilish</a>
            </p>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

//                    'id',
//                    'type',

//                    'name',
                    [
                        'attribute'=>'name',
                        'value'=>function($d){
                            $url = Url::toRoute(['/cp/goods/view','id'=>$d->id]);
                            return Html::a($d->name,$url);
                        },
                        'format'=>'raw',
                    ],
                    'barcode',
                    [
                        'attribute'=>'group_id',
                        'value'=>function($d){
                            return $d->group->name;
                        },
                        'filter'=>\yii\helpers\ArrayHelper::map(GoodsGroup::find()->where(['status'=>1,'type'=>1])->all(),'id','name'),
                    ],
                    [
                        'attribute'=>'unit_id',
                        'value'=>function($d){
                            return $d->unit->name;
                        },
                        'filter'=>\yii\helpers\ArrayHelper::map(\common\models\GoodsUnit::find()->all(),'id','name')
                    ],
                    'price',
                    'come',
                    'sale',
                    'remainder',

                ],
            ]); ?>
        </div>
    </div>


</div>
