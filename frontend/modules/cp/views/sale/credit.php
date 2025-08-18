<?php

use common\models\Sale;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\SaleSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Sotilgan mahsulotlar';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="sale-index">

        <div class="card">
            <div class="card-body">

                <?php echo $this->render('_search', ['model' => $searchModel]); ?>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        [
                            'attribute'=>'code',
                            'value'=>function($d){
                                $url = Yii::$app->urlManager->createUrl(['/cp/sale/view', 'id' => $d->id]);
                                return Html::a('#'.$d->code, $url);
                            },
                            'format'=>'raw'
                        ],
                        
                        'credit',
                        'debt',
                        'price',
                        'call_date_loc',
                        'created',
                        [
                            'attribute'=>'user_id',
                            'value'=>function($d){
                                return $d->user->name;
                            },
                            'filter'=>\yii\helpers\ArrayHelper::map(\common\models\User::find()->all(), 'id', 'name')
                        ],
                        [
                            'label'=>'',
                            'value'=>function($d){
                                $url = Yii::$app->urlManager->createUrl(['/cp/gen/saledprint','id' => $d->id]);
                                return "<button class='btn btn-primary printbtn' value='{$url}'><span class='fa fa-print'></span></button>";
                            },
                            'format'=>'raw'
                        ],
                    ],
                ]); ?>
            </div>
        </div>


    </div>

<?php
$this->registerJs("
    $('.printbtn').click(function(){
        let url = $(this).val();
        window.open(url, '_blank', 'width=600,height=800,toolbar=0,location=0,menubar=0');
        return false;
    })
")
?>
