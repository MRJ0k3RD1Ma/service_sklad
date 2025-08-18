<?php

use common\models\SupplerReturn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\SupplerReturnSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Qaytarilgan mahsulotlar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suppler-return-index">


    <div class="card">
        <div class="card-body">
            <p>
                <?= Html::a('Mahsulotlarni qaytarish', ['/cp/gen/returntosuppler'], ['class' => 'btn btn-success']) ?>
            </p>

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'code',
                    [
                        'attribute' => 'code',
                        'value'=>function($d){
                            $url = Url::toRoute(['/cp/suppler-return/view','id'=>$d->id]);
                            return Html::a($d->code,$url);
                        },
                        'format'=>'raw'
                    ],
                    'date',
//            'code_id',
//            'nakladnoy',
                    //'suppler_id',
                    [
                        'attribute' => 'suppler_id',
                        'value'=>function($d){
                            $url = Url::toRoute(['/cp/suppler/view','id'=>$d->suppler_id]);
                            return Html::a($d->suppler->name,$url);
                        },
                        'format'=>'raw',
                        'filter'=>\yii\helpers\ArrayHelper::map(\common\models\Suppler::find()->where(['status'=>1])->all(),'id','name')
                    ],
                    'price',
                    'comment:ntext',
//                    'register_id',
                    //'status',
                    //'created',
                    //'updated',
                ],
            ]); ?>
        </div>
    </div>


</div>
