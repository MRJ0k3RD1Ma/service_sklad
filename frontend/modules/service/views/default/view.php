<?php
/* @var $model \common\models\Visit*/
$this->title = "{$model->car->number} ( {$model->car->model})";
?>
<!-- header starts -->
<header class="main-header">
    <div class="custom-container">
        <div class="header-panel">
            <a href="<?= Yii::$app->urlManager->createUrl(['/service/'])?>">
                <i class="iconsax icon-btn" data-icon="chevron-left"> </i>
            </a>
            <h3><?= $model->car->number?> <span class="text text-danger">(<?= $model->car->model?>)</span></h3>
        </div>
    </div>
</header>
<!-- header end -->

<!-- pending booking details section starts -->
<section class="section-lg-t-space section-b-space">
    <div class="custom-container">
        <div class="packages-details-wrapper">
            <img class="packages-banner w-100 img-fluid" src="/mobil/img/bgcar.jpg" alt="5">
            <div class="d-flex align-items-center justify-content-between mt-3">
                <h4 class="theme-color fw-medium"><?= $model->date ?></h4>

                <a href="#status" data-bs-toggle="offcanvas" class="status theme-color fw-medium"><?= Yii::$app->params['service.state'][$model->state]?>

                </a>
            </div>

            <div class="d-flex align-items-center justify-content-between mt-3">
                <h4 class="title-color fw-medium">Mashina ma'lumotlari</h4>
            </div>
            <div class="package-booking-details">
                <ul class="listing">
                    <li>
                        <div class="listing-box">
                            <i class="iconsax icon" data-icon="user-1"> </i>
                            <div>
                                <h6 class="title-color listing-title ps-2">Mijoz</h6>
                                <h5 class="content-color ps-2 mt-1 white-nowrap"><?php $client = $model->client; echo $client->name.' '.$client->phone ?></h5>
                            </div>
                        </div>
                    </li>
                </ul>
                <ul class="listing">
                    <li>
                        <div class="listing-box">
                            <i class="iconsax icon" data-icon="money-change"> </i>
                            <div>
                                <h6 class="title-color listing-title ps-2">Kelishilgan narx</h6>
                                <h5 class="content-color ps-2 mt-1 white-nowrap"><?= $model->price ?></h5>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="listing-box">
                            <i class="iconsax icon" data-icon="clock"> </i>
                            <div>
                                <h6 class="title-color listing-title ps-2">Xarajat</h6>
                                <h5 class="content-color ps-2 mt-1"><?= $model->sale->price ?></h5>
                            </div>
                        </div>
                    </li>

                </ul>

                <ul class="listing">
                    <li>
                        <div class="listing-box">
                            <i class="iconsax icon" data-icon="wallet-money"> </i>
                            <div>
                                <h6 class="title-color listing-title ps-2">To'landi</h6>
                                <h5 class="content-color ps-2 mt-1 white-nowrap"><?= $model->debt?></h5>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="listing-box">
                            <i class="iconsax icon" data-icon="wallet-open-time"> </i>
                            <div>
                                <h6 class="title-color listing-title ps-2">Qarzdorlik</h6>
                                <h5 class="content-color ps-2 mt-1"><?= $model->credit ?></h5>
                            </div>
                        </div>
                    </li>

                </ul>

                <ul class="listing">
                    <li>
                        <div class="listing-box">
                            <i class="iconsax icon" data-icon="car"> </i>
                            <div>
                                <h6 class="title-color listing-title ps-2">Raqami</h6>
                                <h5 class="content-color ps-2 mt-1 white-nowrap"><?= $model->car->number  ?></h5>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="listing-box">
                            <i class="iconsax icon" data-icon="driver-1"> </i>
                            <div>
                                <h6 class="title-color listing-title ps-2">Modeli</h6>
                                <h5 class="content-color ps-2 mt-1"><?= $model->car->model ?></h5>
                            </div>
                        </div>
                    </li>
                </ul>

                <ul class="listing">
                    <li>
                        <div class="listing-box">
                            <i class="iconsax icon" data-icon="phone"> </i>
                            <div>
                                <h6 class="title-color listing-title ps-2">Kelish sanasi</h6>
                                <h5 class="content-color ps-2 mt-1 white-nowrap"><?= $model->car->call_date ?></h5>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="listing-box">
                            <i class="iconsax icon" data-icon="speedometer"> </i>
                            <div>
                                <h6 class="title-color listing-title ps-2">Probeg</h6>
                                <h5 class="content-color ps-2 mt-1"><?= $model->car->run ?> km</h5>
                            </div>
                        </div>
                    </li>
                </ul>

                <ul class="listing border-0">
                    <li>
                        <div class="listing-box">
                            <i class="iconsax icon" data-icon="message-dots"> </i>
                            <div>
                                <h6 class="title-color listing-title ps-2">Izoh</h6>
                                <h5 class="content-color ps-2 mt-1"> <?= $model->ads ?>
                                </h5>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>


            <div class="customer-details mt-3">
                <div class="customer-head">
                    <h6 class="title-color fw-medium">Qilingan ishlar</h6>
                </div>
                <?php foreach ($model->visitProducts as $item){ $product = $item->product;?>

                <div class="customer-profile">

                        <div class="profile-content">
                            <div>
                                <h5 class="title-color"><?= $product->name ?></h5>
                                <h6 class="d-flex align-items-center gap-1 mt-1 content-color">
                                    Narxi: <?= $item->price ?> Soni: <?= $item->cnt ?> Summa: <?= $item->cnt_price ?>
                                </h6>
                            </div>
                            <?php if($model->state != 'COMPLETED'){?>
                            <div class="d-flex align-items-center gap-2">
                                <a href="<?= Yii::$app->urlManager->createUrl(['/service/default/updateproduct','id'=>$item->id,'visit_id'=>$model->id])?>">
                                    <i class="iconsax icon" data-icon="edit-1"> </i>
                                </a>
                                <a href="<?= Yii::$app->urlManager->createUrl(['/service/default/deleteproduct','id'=>$item->id,'visit_id'=>$model->id])?>" data-confirm="Siz rostdan ham ushbu elementni o`chirmoqchimisiz?">
                                    <i class="iconsax icon" style="--Iconsax-Color: black !important; !important; background: #fff;" data-icon="trash"> </i>
                                </a>
                            </div>
                            <?php }?>
                        </div>
                </div>
                    <hr style="margin:0 10px;">
                <?php }?>

                <div class="customer-profile">

                    <div class="profile-content">
                        <div>
                            <h5 class="title-color">Umumiy narxi:</h5>

                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <h5 class="title-color"><?= $model->price?></h5>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <?php if($model->state == 'RUNNING'){?>
        <div class="custom-container" style="margin-top: 20px;">
            <div class="d-flex align-items-center gap-3">
                <a href="<?= Yii::$app->urlManager->createUrl(['/service/default/statecompleted','id'=>$model->id ])?>" data-method="post" data-confirm="Siz rostdan ham xizmat ko'rsatishni tugatmoqchimisiz?" class="btn theme-btn w-50" style="width: 100% !important;">Xizmat ko'rsatishni yakunlash </a>
            </div>
        </div>
    <?php }?>
    <?php if($model->state == 'NEW'){ ?>
        <div class="grid-btn fixed-button">
            <div class="custom-container">
                <div class="d-flex align-items-center gap-3">
                    <a href="<?= Yii::$app->urlManager->createUrl(['/service/default/staterun','id'=>$model->id ])?>" data-method="post" data-confirm="Siz rostdan ham xizmat ko'rsatishni boshlamoqchimisiz?" class="btn theme-btn w-50" style="width: 100% !important;">Xizmat ko'rsatishni boshlash </a>
                </div>
            </div>
        </div>
    <?php }elseif($model->state == 'RUNNING'){?>
        <div class="grid-btn fixed-button">
            <div class="custom-container">
                <div class="d-flex align-items-center gap-3">
                    <a href="<?= Yii::$app->urlManager->createUrl(['/service/default/addproduct','id'=>$model->id ])?>" class="btn outline-btn w-50">Mahsulot qo'shish</a>
                    <a href="<?= Yii::$app->urlManager->createUrl(['/service/default/addservice','id'=>$model->id ])?>" class="btn theme-btn w-50">Xizmat qo'shish</a>
                </div>
            </div>
        </div>
    <?php }else{?>
        <script>
            document.getElementById("navbarmenuid").style.display = "block";
        </script>
    <?php }?>

</section>
<!-- pending booking details section end -->