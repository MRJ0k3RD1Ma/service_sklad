<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Goods $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="goods-view">

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">


                    <p>
                        <button class="btn btn-primary md-btnupdate" value="<?= Yii::$app->urlManager->createUrl(['/cp/goods/update','id'=>$model->id])?>">O`zgartirish</button>
                        <?= Html::a('O`chirish', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
//                            'type',
                            'name',
                            'barcode',
//                            'group_id',
                            [
                                'attribute'=>'group_id',
                                'value'=>function($model){
                                    return $model->group->name;
                                }
                            ],
//                            'unit_id',
                            [
                                'attribute'=>'unit_id',
                                'value'=>function($model){
                                    return $model->unit->name;
                                }
                            ],
//                            'image',
//                            'status',
                            'come',
                            'sale',
                            'remainder',
                            'remainder_first',

                            [
                                'attribute'=>'price',
                                'value'=>function($d){
                                    $txt = 'So`m';
                                    if($d->price_type == 'RATE'){
                                        $txt = '$ ('. ($d->price * \common\models\Custom::findOne(['key' => 'exchange-rate'])->value).' so`m)';
                                    }
                                    return $d->price .' '. $txt;
                                }
                            ],
                            [
                                'attribute'=>'price_come',
                                'value'=>function($d){
                                    $txt = 'So`m';
                                    if($d->price_type == 'RATE'){
                                        $txt = '$ ('. ($d->price_come * \common\models\Custom::findOne(['key' => 'exchange-rate'])->value).' so`m)';
                                    }
                                    return $d->price_come .' '. $txt;
                                }
                            ],
//                            'price_come',
                            [
                                'attribute'=>'status',
                                'value'=>function($model){
                                    return Yii::$app->params['status'][$model->status];
                                }
                            ],
                            'created',
                            'updated',

                            [
                                'attribute'=>'image',
                                'value'=>function($model){
                                    if($model->image != 'default/nophoto.png'){
                                        return "<img src='/upload/goods/tmp/{$model->image}' alt='{$model->image}' style='width: 100px'>";
                                    }else{
                                        return "<img src='/upload/{$model->image}' alt='{$model->image}' style='width: 100px'>";
                                    }
                                },
                                'format'=>'raw',
                            ],
                        ],
                    ]) ?>

                    <div class="row">
                        <?php if(strlen($model->barcode) == 13){$url = Yii::$app->urlManager->createUrl(['/cp/barcode/generate13','code'=>$model->barcode]);}else{
                            $url = Yii::$app->urlManager->createUrl(['/cp/barcode/generate14','code'=>$model->barcode]);
                        }?>
                        <div class="col-md-12" style="border: 1px solid #000; padding-top:20px;">
                            <img src="<?= $url?>" style="width:100%; height:auto" alt="">
                            <p style="text-align: center; padding: 0; margin:0; font-size:35px; font-weight: bold"><?= $model->barcode?></p>
                            <p style="text-align:center; padding:0; margin:0;"><?= $model->name?></p>
                            <p style="text-align: center; padding:0; margin:0;">Narxi: <b><?= $model->price * \common\models\Custom::findOne(['key'=>'exchange-rate'])->value; ?> so`m</b></p>
                        </div>

                        <div class="col-md-12" style="margin-top: 20px;">
                            <button class='btn btn-primary form-control printbtn' style="height:60px !important; color: #fff" value='<?= Yii::$app->urlManager->createUrl(['/cp/barcode/pdfgen','id'=>$model->id])?>'><span class='fa fa-print'></span> Pechatga chiqarish</button>
                        </div>
                    </div>


                </div>

                <div class="col-md-9">
                    <div class="pd-20 card-box">
                        <h5 class="h4 text-blue mb-20">Yetkazuvchi bilan munosabatlar</h5>
                        <div class="tab">
                            <ul class="nav nav-tabs customtab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#home2" role="tab" aria-selected="true">Sotuvlar</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#profile2" role="tab" aria-selected="false">Skladga qabul qilinganlar</a>
                                </li>

                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="home2" role="tabpanel" style="padding-top:20px;">
                                    <?= \yii\grid\GridView::widget([
                                        'dataProvider' => $dataProviderSale,
//                                        'filterModel' => $searchModelSale,
                                        'columns' => [
                                            ['class' => 'yii\grid\SerialColumn'],

//                                            'product_id'
                                            [
                                                'attribute'=>'sale_id',
                                                'value'=>function($d){
                                                    $url = Yii::$app->urlManager->createUrl(['/cp/sale/view','id'=>$d->sale_id]);
                                                    return Html::a($d->sale->code, $url);
                                                },
                                                'format'=>'raw',
                                                'filter'=>false
                                            ],

                                            [
                                                'attribute'=>'price',
                                                'value'=>function($d){
                                                    return $d->price.' so`mdan';
                                                },
                                            ],
                                            [
                                                'attribute'=>'cnt',
                                                'value'=>function($d){
                                                    return $d->cnt.' '.$d->product->unit->name;
                                                }
                                            ],
                                            [
                                                'attribute'=>'price',
                                                'value'=>function($d){
                                                    return $d->cnt_price.' so`m';
                                                },
                                            ],
                                        ],
                                    ]); ?>
                                </div>

                                <div class="tab-pane fade" id="profile2" role="tabpanel"  style="padding-top:20px;">
                                    <?= \yii\grid\GridView::widget([
                                        'dataProvider' => $dataProviderIncome,
//                                        'filterModel' => $searchModelIncome,
                                        'columns' => [
                                            ['class' => 'yii\grid\SerialColumn'],
                                            [
                                                'label'=>'Chek raqami',
                                                'value'=>function($d){
                                                    $url = Yii::$app->urlManager->createUrl(['/cp/come/view','id'=>$d->come_id]);
                                                    return Html::a($d->come->code, $url);
                                                },
                                                'filter'=>false,
                                                'format'=>'raw',
                                            ],
                                            [
                                                'attribute'=>'price',
                                                'value'=>function($d){
                                                    return $d->price.' so`mdan';
                                                },
                                            ],
                                            [
                                                'attribute'=>'cnt',
                                                'value'=>function($d){
                                                    return $d->cnt.' '.$d->goods->unit->name;
                                                }
                                            ],
                                            [
                                                'attribute'=>'price',
                                                'value'=>function($d){
                                                    return $d->cnt_price.' so`m';
                                                },
                                            ],

                                        ],
                                    ]); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


            </div>


            <div class="row">
                <div class="col-md-12">
                    <h4>Sotuvlar statistikasi</h4>

                    <div id="chart-yearly"></div>

                </div>
            </div>


        </div>
    </div>

</div>



<?php
$this->registerJs("
    $('.printbtn').click(function(){
        let childWin = window.open(this.value,'childWindow', 'width=600,height=800');
        if (childWin) {
        //childWin.document.open();
            childWin.opener = window; // Bu parent oynani bog‘lash uchun
        }
    })
")
?>


<?php
$this->registerJsFile('@web/design/src/plugins/apexcharts/apexcharts.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@web/design/src/plugins/apexcharts/apexcharts.min.css', ['depends' => [\yii\web\JqueryAsset::className()]]);


$this->registerJs("    
    var options = {
        chart: {
            type: 'line',
            height: 350,
            toolbar: {
                show: false
            }
        },
        series: [{
            name: 'Sotuvlar',
            data: " . json_encode(\common\models\SaleProduct::getYearlyData($year,$model->id)) . "
        }],
        xaxis: {
            categories: " . json_encode(\common\models\Paid::getMonths()) . "
        },
        yaxis: {
            title: {
                text: 'Sotuvlar'
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function (val) {
                return numberFormat(val);
            }
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return numberFormat(val) + ' {$model->unit->name}';
                }
            }
        }
    };
    function numberFormat(x) {
        return x.toString().replace(/\B(?=(\\d{3})+(?!\\d))/g, ' ');
    }
    var chart = new ApexCharts(document.querySelector('#chart-yearly'), options);
    chart.render();
");
?>

