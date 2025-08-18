<!-- wallet balance section starts -->
<section class="section-lg-t-space">
    <div class="custom-container">
        <div class="wallet-balance-box">
            <img class="img-fluid wallet-icon" src="/mobil/img/wallet-open.svg" alt="p8">
            <div class="wallet-details">
                <div>
                    <h5>Bugungi ta'mirlagan moshinalarim: </h5>
                    <h4><?= \common\models\Visit::find()->where(['state'=>'COMPLETED','status'=>1,'user_id'=>Yii::$app->user->id])
                            ->andFilterWhere(['like','updated',date('Y-m-d')])
                            ->count('*')
                        ?></h4>
                </div>
                <a href="<?= Yii::$app->urlManager->createUrl(['/service/default/completed','type'=>'today'])?>" class="btn-sm theme-btn withdraw-btn theme-color">Ko'rish</a>
            </div>
        </div>
    </div>
</section>
<!-- wallet balance section end -->

<!-- counter section starts -->
<section class="section-b-space">
    <div class="custom-container">
        <div class="row g-3">
            <div class="col-12">
                <a href="<?= Yii::$app->urlManager->createUrl(['/service/default/new'])?>" class="provider-counter-box">
                    <i class="iconsax counter-icon" data-icon="clock"></i>
                    <div class="provider-counter-details">
                        <h6>Ta'mirlash boshlanmagan moshinalar:</h6>
                        <div class="d-flex align-items-center justify-content-between mt-1">
                            <h4><?= \common\models\Visit::find()->where(['=','state','NEW'])->andWhere(['status'=>1,'user_id'=>Yii::$app->user->id])->count('*') ?></h4>
                            <i class="iconsax arrow-icon" data-icon="arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-7">
                <a href="<?= Yii::$app->urlManager->createUrl(['/service/default/completed','type'=>'month'])?>" class="provider-counter-box">
                    <i class="iconsax counter-icon" data-icon="money-in"></i>
                    <div class="provider-counter-details">
                        <h6>Bu oydagi tamirlashlar</h6>
                        <div class="d-flex align-items-center justify-content-between mt-1">
                            <h4><?= \common\models\Visit::find()->where(['state'=>'COMPLETED','status'=>1,'user_id'=>Yii::$app->user->id])->andFilterWhere(['like','updated',date('Y-m-')])->count('*')?></h4>
                            <i class="iconsax arrow-icon" data-icon="arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-5">
                <a href="<?= Yii::$app->urlManager->createUrl(['/service/default/running'])?>" class="provider-counter-box">
                    <i class="iconsax counter-icon" data-icon="receipt-minus-1"></i>
                    <div class="provider-counter-details">
                        <h6>Jarayondagilar</h6>
                        <div class="d-flex align-items-center justify-content-between mt-1">
                            <h4><?= \common\models\Visit::find()->where(['=','state','RUNNING'])->andWhere(['status'=>1,'user_id'=>Yii::$app->user->id])->count('*') ?></h4>
                            <i class="iconsax arrow-icon" data-icon="arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12">
                <a href="<?= Yii::$app->urlManager->createUrl(['/service/default/completed'])?>" class="provider-counter-box">
                    <i class="iconsax counter-icon" data-icon="box"></i>
                    <div class="provider-counter-details">
                        <h6>Barcha tugallagan termirlashlarim:</h6>
                        <div class="d-flex align-items-center justify-content-between mt-1">
                            <h4><?= \common\models\Visit::find()->where(['=','state','COMPLETED'])->andWhere(['status'=>1,'user_id'=>Yii::$app->user->id])->count('*') ?></h4>
                            <i class="iconsax arrow-icon" data-icon="arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
</section>
<!-- counter section end -->


<!-- recent bookings section starts -->
<section class="box-background section-b-space">
    <div class="custom-container">
        <div class="title">
            <h3>Jarayondagi ta'mirlashlar</h3>
            <a href="<?= Yii::$app->urlManager->createUrl(['/service/default/running'])?>">Barchasini ko'rish</a>
        </div>
        <ul class="booking-list">

        <?php foreach (\common\models\Visit::find()->where(['status'=>1,'state'=>'RUNNING','user_id'=>Yii::$app->user->id])->orderBy(['id'=>SORT_ASC])->limit(10)->all() as $item):?>
                <li class="booking-box" onclick="window.location.href='<?= Yii::$app->urlManager->createUrl(['/service/default/view','id'=>$item->id])?>'">
                    <div class="booking-details">
                        <div class="d-flex align-items-center gap-2">
                            <div class="service-content">
                                <h5 class="theme-color fw-medium mb-1"><?= date('d.m.Y',strtotime($item->date))?></h5>
                                <div class="d-flex align-items-center gap-2 mt-1">
                                    <h3 class="title-color fw-bold "><?= $item->car->number?></h3>
                                    <h6 class="error-color fw-medium">(<?= $item->car->model?>)</h6>
                                </div>
                            </div>
                        </div>
                        <div class="line-box">
                            <div class="dot1"></div>
                            <div class="dot2"></div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mt-1">
                            <h6 class="fw-medium content-color">Status</h6>
                            <h6 class="booking-tag pending-bg"><?= Yii::$app->params['service.state'][$item->state]?></h6>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <h6 class="fw-medium content-color">Oxirgi o'zgarish</h6>
                            <h6 class="fw-medium title-color"><?= $item->updated ?></h6>
                        </div>

                    </div>
                </li>
        <?php endforeach;?>
        </ul>

    </div>
</section>
<!-- recent bookings section end -->
