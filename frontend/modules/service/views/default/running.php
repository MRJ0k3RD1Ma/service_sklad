<?php
$this->title="Ta'mirlash jarayonidagi moshinalar ro'yhati"
?>

<!-- header starts -->
<header class="main-header">
    <div class="custom-container">
        <div class="header-panel">
            <a href="#sidebar" class="sidebar-btn" data-bs-toggle="offcanvas">
                <i class="iconsax" data-icon="text-align-left"></i>
            </a>
            <h3>Jarayondagi ta'mirlashlar</h3>
            <a href="<?= Yii::$app->urlManager->createUrl(['/service/default/new'])?>">
                <i class="iconsax icon-btn <?= \common\models\Visit::find()->where(['user_id'=>Yii::$app->user->id,'state'=>'NEW'])->count('*') > 0 ? 'notification-icon' : ''?>" data-icon="bell-2"></i>
            </a>
        </div>
    </div>
</header>
<!-- header end -->


<!-- booking section starts -->
<section class="section-b-space section-lg-t-space">
    <div class="custom-container">
        <form class="auth-form mt-0 p-0 bg-transparent" id="search-form-1" action="<?= Yii::$app->urlManager->createUrl(['/service/default/running'])?>">
            <div class="form-group mt-0">
                <div class="form-input">
                    <input type="search" value="<?= $search?>" name="search" class="form-control search with-filter" id="inputusername"
                           placeholder="Moshina raqami ">
                    <i class="iconsax search-icon" data-icon="search-normal-2"> </i>

                </div>
            </div>
        </form>

        <?php $this->registerJs("
            $('#searchsubmit').click(function(){
                $('#search-form-1').submit();
            })
        ")?>
        <h3 class="mt-3 inner-sub-title">Barcha ta'mirlash jarayonidagi moshinalar ro'yhati</h3>
        <ul class="booking-list">

        <?php foreach ($model as $item):?>
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
<!-- booking section end -->
<form>
<!-- filter offcanvas starts -->
<div class="offcanvas offcanvas-bottom filter-offcanvas" tabindex="-1" id="filter">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasBottomLabel">Filter</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body pt-2">
        <div class="tab-content" id="myTabContent1">

            <div class=" tab-pane fade show active" id="status" role="tabpanel" tabindex="0">
                <ul class="categories-listing">
                    <li class="listing-categories">
                        <div class="form-check form-check-reverse text-start">
                            <label class="form-check-label" for="booking1">
                                    <span class="d-flex align-items-center">
                                        <span class="categories-name ps-0 border-0">All Booking</span>
                                    </span>
                            </label>
                            <input class="form-check-input" type="radio" name="booking" id="booking1" checked>
                        </div>
                    </li>
                    <li class="listing-categories">
                        <div class="form-check form-check-reverse text-start">
                            <label class="form-check-label" for="booking2">
                                    <span class="d-flex align-items-center">
                                        <span class="categories-name ps-0 border-0">Pending Booking</span>
                                    </span>
                            </label>
                            <input class="form-check-input" type="radio" name="booking" id="booking2">
                        </div>
                    </li>
                    <li class="listing-categories">
                        <div class="form-check form-check-reverse text-start">
                            <label class="form-check-label" for="booking3">
                                    <span class="d-flex align-items-center">
                                        <span class="categories-name ps-0 border-0">Accepted Booking</span>
                                    </span>
                            </label>
                            <input class="form-check-input" type="radio" name="booking" id="booking3">
                        </div>
                    </li>
                    <li class="listing-categories">
                        <div class="form-check form-check-reverse text-start">
                            <label class="form-check-label" for="booking4">
                                    <span class="d-flex align-items-center">
                                        <span class="categories-name ps-0 border-0">Ongoing Booking</span>
                                    </span>
                            </label>
                            <input class="form-check-input" type="radio" name="booking" id="booking4">
                        </div>
                    </li>
                    <li class="listing-categories">
                        <div class="form-check form-check-reverse text-start">
                            <label class="form-check-label" for="booking5">
                                    <span class="d-flex align-items-center">

                                        <span class="categories-name ps-0 border-0">Complete Booking</span>
                                    </span>
                            </label>
                            <input class="form-check-input" type="radio" name="booking" id="booking5">
                        </div>
                    </li>
                    <li class="listing-categories">
                        <div class="form-check form-check-reverse text-start">
                            <label class="form-check-label" for="booking6">
                                    <span class="d-flex align-items-center">
                                        <span class="categories-name ps-0 border-0">Cancelled Booking</span>
                                    </span>
                            </label>
                            <input class="form-check-input" type="radio" name="booking" id="booking6">
                        </div>
                    </li>
                </ul>
            </div>

        </div>
    </div>
    <div class="grid-btn fixed-button position-relative">
        <div class="custom-container">
            <div class="d-flex align-items-center gap-3">
                <a href="booking.html" class="btn outline-btn w-50">Clear all</a>
                <a href="booking.html" class="btn theme-btn w-50">Apply</a>
            </div>
        </div>
    </div>
</div>
<!-- filter offcanvas end -->
</form>
