<?php $this->title = 'Dashboard';

$this->registerJsFile('@web/design/src/plugins/apexcharts/apexcharts.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@web/design/src/plugins/apexcharts/apexcharts.min.css', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<div class="row pb-10">
    <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
        <a href="<?= Yii::$app->urlManager->createUrl(['/cp/paid/','PaidSearch[period_start]'=>date('Y-m-d'),'PaidSearch[period_end]'=>date('Y-m-t')])?>">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark">
                            <?= number_format(
                                    round(
                                            \common\models\Paid::find()
                                                ->where(['status'=>1])
                                                ->andFilterWhere(['like','date',date('Y-m-')])
                                                ->sum('price')
                                            ,0

                                    ),0,'.',' ')
                            ?> so'm</div>
                        <div class="font-14 text-secondary weight-500">
                            (<?= Yii::$app->params['month'][intval(date('m'))]?>) tushum
                        </div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" data-color="#00eccf">
                            <i class="icon-copy dw dw-24-hours"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
        <a href="<?= Yii::$app->urlManager->createUrl(['/cp/paid/','PaidSearch[period_start]'=>date('Y-m-d'),'PaidSearch[period_end]'=>date('Y-m-t')])?>">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark">
                            <?= number_format(
                                    round(

                                        \common\models\PaidOther::find()->where(['status'=>1,'type'=>'INCOME'])
                                            ->andFilterWhere(['like','paid_date',date('Y-m-')])
                                            ->sum('price')
                                            ,0

                                    ),0,'.',' ')
                            ?> so'm</div>
                        <div class="font-14 text-secondary weight-500">
                            (<?= Yii::$app->params['month'][intval(date('m'))]?>) Ustavga kiritilgan mablag'
                        </div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" data-color="#00eccf">
                            <i class="icon-copy dw dw-24-hours"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
        <a href="<?= Yii::$app->urlManager->createUrl(['/cp/paid/','PaidSearch[period_start]'=>date('Y-m-d'),'PaidSearch[period_end]'=>date('Y-m-t')])?>">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark">
                            <?= number_format(
                                round(

                                    \common\models\PaidOther::find()->where(['status'=>1,'type'=>'OUTCOME'])
                                        ->andFilterWhere(['like','paid_date',date('Y-m-')])
                                        ->sum('price')
                                    ,0

                                ),0,'.',' ')
                            ?> so'm</div>
                        <div class="font-14 text-secondary weight-500">
                            (<?= Yii::$app->params['month'][intval(date('m'))]?>) Boshqa xarajatlar
                        </div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" data-color="#00eccf">
                            <i class="icon-copy dw dw-24-hours"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
        <a href="<?= Yii::$app->urlManager->createUrl(['/cp/paid/','PaidSearch[period_start]'=>date('Y-m-d'),'PaidSearch[period_end]'=>date('Y-m-t')])?>">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark">
                            <?= number_format(
                                round(

                                    \common\models\PaidWorker::find()->where(['status'=>1])
                                        ->andFilterWhere(['like','date',date('Y-m-')])
                                        ->sum('price')
                                    ,0

                                ),0,'.',' ')
                            ?> so'm</div>
                        <div class="font-14 text-secondary weight-500">
                            (<?= Yii::$app->params['month'][intval(date('m'))]?>) Brigaderlarga berildi
                        </div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" data-color="#00eccf">
                            <i class="icon-copy dw dw-24-hours"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>


    <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
        <a href="<?= Yii::$app->urlManager->createUrl(['/cp/paid/','PaidSearch[period_start]'=>date('Y-m-d'),'PaidSearch[period_end]'=>date('Y-m-t')])?>">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark">
                            <?= number_format(
                                round(

                                    \common\models\Sale::find()->where(['status'=>1,'state'=>'DONE'])
                                        ->andFilterWhere(['like','updated',date('Y-m-')])
                                        ->count('id')
                                    ,0

                                ),0,'.',' ')
                            ?> ta</div>
                        <div class="font-14 text-secondary weight-500">
                            (<?= Yii::$app->params['month'][intval(date('m'))]?>) Tugallangan ishlar
                        </div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" data-color="#00eccf">
                            <i class="icon-copy dw dw-24-hours"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
        <a href="<?= Yii::$app->urlManager->createUrl(['/cp/paid/','PaidSearch[period_start]'=>date('Y-m-d'),'PaidSearch[period_end]'=>date('Y-m-t')])?>">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark">
                            <?= number_format(
                                round(

                                    \common\models\Sale::find()->where(['status'=>1])
                                        ->andFilterWhere(['like','date',date('Y-m-')])
                                        ->count('id')
                                    ,0

                                ),0,'.',' ')
                            ?> ta</div>
                        <div class="font-14 text-secondary weight-500">
                            (<?= Yii::$app->params['month'][intval(date('m'))]?>) Barcha ishlar
                        </div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" data-color="#00eccf">
                            <i class="icon-copy dw dw-24-hours"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
        <a href="<?= Yii::$app->urlManager->createUrl(['/cp/paid/','PaidSearch[period_start]'=>date('Y-m-d'),'PaidSearch[period_end]'=>date('Y-m-t')])?>">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark">
                            <?= number_format(
                                round(
                                    \common\models\Paid::find()
                                        ->where(['status'=>1])
                                        ->andFilterWhere(['like','date',date('Y-')])
                                        ->sum('price')
                                    ,0

                                ),0,'.',' ')
                            ?> so'm</div>
                        <div class="font-14 text-secondary weight-500">
                            Yillik tushum
                        </div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" data-color="#00eccf">
                            <i class="icon-copy dw dw-24-hours"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
        <a href="<?= Yii::$app->urlManager->createUrl(['/cp/paid/','PaidSearch[period_start]'=>date('Y-m-d'),'PaidSearch[period_end]'=>date('Y-m-t')])?>">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark">
                            <?= number_format(
                                round(
                                    \common\models\Client::find()
                                        ->where(['status'=>1])
                                        ->andWhere(['<','balance',0])
                                        ->sum('balance')
                                    ,0

                                ),0,'.',' ')
                            ?> so'm</div>
                        <div class="font-14 text-secondary weight-500">
                            Barcha qarzdorliklar
                        </div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" data-color="#00eccf">
                            <i class="icon-copy dw dw-24-hours"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<?php if(false){?>
<div class="row pb-10">
    <div class="col-md-8 mb-20">
        <div class="card-box height-100-p pd-20">
            <div class="d-flex flex-wrap justify-content-between align-items-center pb-0 pb-md-3">
                <div class="h5 mb-md-0">Bugun to'lashi kerak bo'lganlar</div>
                <div class="form-group mb-md-0">
                    <a href="#">Barchasi <span class="fa fa-chevron-right"></span></a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Mijoz</th>
                            <th>Telefon</th>
                            <th>Qarzdorlik</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-20">
        <div
            class="card-box min-height-200px pd-20 mb-20"
            data-bgcolor="#455a64"
        >
            <div class="d-flex justify-content-between pb-20 text-white">
                <div class="icon h1 text-white">
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                </div>
                <div class="font-14 text-right">
                    <div>0
                    </div>
                    <div class="font-12">O'tgan oyda</div>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-end">
                <div class="text-white">
                    <div class="font-14">Tashriflar soni</div>
                    <div class="font-24 weight-500">
                        0
                    </div>
                </div>

            </div>
        </div>
        <div class="card-box min-height-200px pd-20" data-bgcolor="#265ed7">
            <div class="d-flex justify-content-between pb-20 text-white">
                <div class="icon h1 text-white">
                    <i class="fa fa-stethoscope" aria-hidden="true"></i>
                </div>
                <div class="font-14 text-right">
                    <div> <?= number_format(0,0,'.',' ')?></div>
                    <div class="font-12">O'tgan oyda</div>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-end">
                <div class="text-white">
                    <div class="font-14">Sotuvlar soni</div>
                    <div class="font-24 weight-500"><?= number_format(0,0,'.',' ')?></div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php }?>

<div class="row pb-10">
    <div class="col-md-12 mb-20">
        <div class="card-box height-100-p pd-20">
            <div class="d-flex flex-wrap justify-content-between align-items-center pb-0 pb-md-3">
                <div class="h5 mb-md-0">Tushumlar statistikasi</div>
            </div>


            <div id="chart-yearly"></div>

        </div>

    </div>

</div>

<?php

$dailyUrl = Yii::$app->urlManager->createUrl(['/cp/default/daily']);
$this->registerJs("    

    var months = " . json_encode(Yii::$app->params['month']) . ";
    var currentView = 'yearly';

    var options = {
        chart: {
            type: 'line',
            height: 350,
            toolbar: {
                show: false
            },
            events: {
            markerClick: function(event, chartContext, { seriesIndex, dataPointIndex, config }) {
                var monthIndex = dataPointIndex + 1;
                loadDaily(monthIndex);
            }
        }
        },
        series: [{
            name: 'Tushumlar',
            data: " . json_encode(\common\models\Paid::getYearlyData($year)) . "
        }],
        xaxis: {
            categories: " . json_encode(Yii::$app->params['month']) . "
        },
        yaxis: {
            title: {
                text: 'Tushumlar'
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
                    return numberFormat(val) + ' so`m';
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

