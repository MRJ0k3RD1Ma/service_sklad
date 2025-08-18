<?php

use common\models\Come;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\ComeSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Skladga qabul qilingan mahsulotlar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="come-index">


    <div class="card">
        <div class="card-body">
            <p>
                <?= Html::a('Mahsulot qabul qilish', ['/cp/gen/income'], ['class' => 'btn btn-success']) ?>
            </p>

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

//                    'id',
//                    'code',
                    [
                        'attribute'=>'code',
                        'value'=>function($d){
                            $url = Yii::$app->urlManager->createUrl(['/cp/come/view','id'=>$d->id]);
                            return Html::a($d->code,$url);
                        },
                        'format'=>'raw',
                    ],
                    'date',
//                    'code_id',
                    'nakladnoy',
                    //'suppler_id',
                    [
                        'attribute'=>'suppler_id',
                        'value'=>function($d){
                            return $d->suppler->name;
                        },
                        'filter'=>ArrayHelper::map(\common\models\Suppler::find()->where(['status'=>1])->all(),'id','name'),

                    ],
//                    'price',
                    [
                        'attribute'=>'price',
                        'value'=>function($d){
                            return $d->price .' so`m';
                        }
                    ],
                    //'comment:ntext',
                    //'register_id',
                    //'status',
//                    'created',
                    //'updated',

                ],
            ]); ?>
        </div>
    </div>


</div>
