<div class="row pb-10">
    <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
        <a href="<?= Yii::$app->urlManager->createUrl(['/cp/transaction','TransactionSearch[state]'=>'CHECK'])?>">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark"><?= \common\models\Transaction::find()->where(['state'=>'CHECK','status'=>1])->count('*')?></div>
                        <div class="font-14 text-secondary weight-500">
                            Yangi depozitlar
                        </div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" data-color="#00eccf">
                            <i class="icon-copy dw dw-money"></i>
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
                    <div class="weight-700 font-24 text-dark"><?= \common\models\Transaction::find()->where(['state'=>'CHECK','status'=>1])->sum('price')?></div>
                    <div class="font-14 text-secondary weight-500">
                        Yangi depozitlar
                    </div>
                </div>
                <div class="widget-icon">
                    <div class="icon" data-color="#00eccf">
                        <span class="icon-copy dw dw-money"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
        <a href="<?= Yii::$app->urlManager->createUrl(['/cp/payout','PayoutSearch[state]'=>'NEW'])?>">
        <div class="card-box height-100-p widget-style3">
            <div class="d-flex flex-wrap">
                <div class="widget-data">
                    <div class="weight-700 font-24 text-dark"><?= \common\models\Payout::find()->where(['state'=>'NEW','status'=>1])->count('*')?></div>
                    <div class="font-14 text-secondary weight-500">
                        Yangi pul chiqarishlar
                    </div>
                </div>
                <div class="widget-icon">
                    <div class="icon" data-color="#ff5b5b">
                        <i
                            class="icon-copy fa fa-money"
                            aria-hidden="true"
                        ></i>
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
                    <div class="weight-700 font-24 text-dark"><?= \common\models\Transaction::find()->where(['state'=>'DONE','status'=>1])->sum('price') ? : 0?></div>
                    <div class="font-14 text-secondary weight-500">Bugungi umumiy depozitlar</div>
                </div>
                <div class="widget-icon">
                    <div class="icon" data-color="#ff5b5b">
                        <i class="icon-copy fa fa-money" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>