<?php $this->title = 'Dashboard';

$this->registerJsFile('@web/design/src/plugins/apexcharts/apexcharts.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@web/design/src/plugins/apexcharts/apexcharts.min.css', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<?php $cnt = 0;

if($cnt > 0){?>
<div class="row pb-10">
    <div class="col-xl-12 col-lg-12 col-md-12 mb-10">
        <div class="alert alert-primary" role="alert">
            <a href="<?= Yii::$app->urlManager->createUrl(['/cp/visit/notprinted'])?>">Sizda hozr tugallangan va hisoblashilmagan <b><?= $cnt?> ta</b> tashriflar bor!</a>
        </div>
    </div>
</div>
<?php }?>

<div class="row pb-10">
    <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
        <a href="<?= Yii::$app->urlManager->createUrl(['/cp/paid/','PaidSearch[period_start]'=>date('Y-m-d'),'PaidSearch[period_end]'=>date('Y-m-t')])?>">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark"><?= number_format(round(\common\models\Paid::find()->where(['date'=>date('Y-m-d'),'status'=>1])->sum('price'),0),0,'.',' ')?> so'm</div>
                        <div class="font-14 text-secondary weight-500">
                            Bugungi tushum
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
        <a href="<?= Yii::$app->urlManager->createUrl(['/cp/paid/','PaidSearch[period_start]'=> date('Y-m-01'),'PaidSearch[period_end]'=>date('Y-m-d')])?>">
        <div class="card-box height-100-p widget-style3">
            <div class="d-flex flex-wrap">
                <div class="widget-data">
                    <div class="weight-700 font-24 text-dark"><?= number_format(round(\common\models\Paid::find()->where(['status'=>1])->andFilterWhere(['like','date',date('Y-m-')])->sum('price'),0),0,'.',' ')?> so'm</div>
                    <div class="font-14 text-secondary weight-500">
                        Bu oydagi tushum
                    </div>
                </div>
                <div class="widget-icon">
                    <div class="icon" data-color="#ff5b5b">
                        <span class="icon-copy fa fa-money"></span>
                    </div>
                </div>
            </div>
        </div>
        </a>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
        <div class="card-box height-100-p widget-style3">
            <div class="d-flex flex-wrap">
                <div class="widget-data">
                    <div class="weight-700 font-24 text-dark">
                        <?php
                        $sale = 0;
                        echo number_format(round($sale,0),0,'.',' ');
                        ?> so'm
                    </div>
                    <div class="font-14 text-secondary weight-500">
                        Bugun to'lanishi kerak
                    </div>
                </div>
                <div class="widget-icon">
                    <div class="icon">
                        <i class="icon-copy dw dw-24-hours"
                            aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
        <div class="card-box height-100-p widget-style3">
            <div class="d-flex flex-wrap">
                <div class="widget-data">
                    <div class="weight-700 font-24 text-dark">
                        <?php
                            $sale = 0;
                            echo number_format(round($sale,0),0,'.',' ');
                        ?> so'm
                    </div>
                    <div class="font-14 text-secondary weight-500">Jami qarzdorlik</div>
                </div>
                <div class="widget-icon">
                    <div class="icon" data-color="#09cc06">
                        <i class="icon-copy fa fa-credit-card" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

<div class="row pb-10">
    <div class="col-md-12 mb-20">
        <div class="card-box height-100-p pd-20">
            <div class="d-flex flex-wrap justify-content-between align-items-center pb-0 pb-md-3">
                <div class="h5 mb-md-0">Kunlik tushumlar</div>
            </div>


            <div id="chart-monthly"></div>

        </div>

    </div>

</div>

<div class="row pb-10">
    <div class="col-md-12 mb-20">
        <div class="card-box height-100-p pd-20">
            <div class="d-flex flex-wrap justify-content-between align-items-center pb-0 pb-md-3">
                <div class="h5 mb-md-0">Bu oyda eng ko'p sotilgan mahsulotlar</div>
            </div>


            <div id="chart-topproduct"></div>

        </div>

    </div>
</div>
<?php

$dailyUrl = Yii::$app->urlManager->createUrl(['/cp/default/daily']);
$this->registerJs("    

    var months = " . json_encode(\common\models\Paid::getMonths()) . ";
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
            categories: " . json_encode(\common\models\Paid::getMonths()) . "
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


<?php
$this->registerJs("    
    var options3 = {
        chart: {
            type: 'line',
            height: 350,
            toolbar: {
                show: false
            },
        },
        series: [{
            name: 'Sotilgan mahsulotlar',
            data: " . json_encode(\common\models\Paid::getTopProductsData()) . "
        }],
        xaxis: {
            type: 'TOP 20'
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
        return x.toString().replace(/\\B(?=(\\d{3})+(?!\\d))/g, ' ');
    }

    var chart3 = new ApexCharts(document.querySelector('#chart-monthly'), options3);
    chart3.render();
    
    
    loadDaily({$month_number});
    
    
    function loadDaily(month) {
    fetch('$dailyUrl?year={$year}&month=' + month)
        .then(res => res.json())
        .then(data => {
            chart3.updateOptions({
                series: [{ name: 'Kunlik', data: data }],
                xaxis: { type: 'datetime' },
                title: { text: months[month - 1] + ' {$year} kunlik statistika' }
            });
            currentView = 'daily';
            document.getElementById('backBtn').style.display = 'inline-block';
        });
}
");
?>

<?php
$this->registerJs("    
    var options2 = {
        chart: {
            type: 'bar',
            height: 350,
            toolbar: {
                show: false
            },
            events: {
                dataPointSelection: function(event, chartContext, config) {
                    var data = config.w.config.series[config.seriesIndex].data[config.dataPointIndex];
                    if (data.t) {
                        window.location.href = '/cp/goods/view?id=' + data.t;
                    }
                }
            }
        },
        series: [{
            name: 'Sotilgan mahsulotlar',
            data: " . json_encode(\common\models\Paid::getTopProductsData()) . "
        }],
        xaxis: {
            type: 'TOP 20'
        },
        dataLabels: {
            enabled: true,
            formatter: function (val) {
                return numberFormat(val);
            }
        },
        tooltip: {
            y: {
                formatter: function (val, opts) {
                     var data = opts.w.config.series[opts.seriesIndex].data[opts.dataPointIndex];
                    return numberFormat(val) + ' ' + data.f; // qiymat + unit
                 
                }
            }
        }
    };

    function numberFormat(x) {
        return x.toString().replace(/\\B(?=(\\d{3})+(?!\\d))/g, ' ');
    }

    var chart2 = new ApexCharts(document.querySelector('#chart-topproduct'), options2);
    chart2.render();
");
?>
