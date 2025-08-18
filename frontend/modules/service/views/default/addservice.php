<?php
$this->title = "Mahsulot qo`shish";

?>

<!-- header starts -->
<header class="main-header">
    <div class="custom-container">
        <div class="header-panel">
            <a href="<?= Yii::$app->urlManager->createUrl(['/service/defualt/view','id'=>$visit->id ])?>">
                <i class="iconsax icon-btn" data-icon="chevron-left"> </i>
            </a>
            <h3><?= $visit->car->number?> <span class="text text-danger">(<?= $visit->car->model?>)</span></h3>
        </div>
    </div>
</header>
<!-- header end -->
<!-- available servicemen section starts -->
<section class="section-b-space" style="padding-top:80px;">
    <div class="custom-container">
        <div class="title">
            <h3>Xizmat turini tanlang</h3>
        </div>

        <div class="row g-3">

            <?php foreach ($model as $item):?>

                <div class="col-6">
                    <div class="available-servicemen-box">
                        <a href="<?= Yii::$app->urlManager->createUrl(['/service/default/chooseservice','id'=>$visit->id,'group_id'=>$item->id])?>" class="servicemen-img">
                            <img class="img-fluid image w-100" src="<?php if($item->image != 'default/nophoto.png'){
                                echo "/upload/goodsgroup/tmp/{$item->image}";
                            }else{
                                echo "/upload/{$item->image}";
                            } ?>" alt="1">
                        </a>

                        <div class="service-details">
                            <a href="<?= Yii::$app->urlManager->createUrl(['/service/default/chooseservice','id'=>$visit->id,'group_id'=>$item->id])?>">
                                <h5><?= $item->name ?></h5>
                            </a>
                            <a href="<?= Yii::$app->urlManager->createUrl(['/service/default/chooseservice','id'=>$visit->id,'group_id'=>$item->id])?>" class="btn theme-btn">Xizmat tanlash</a>
                        </div>
                    </div>
                </div>


            <?php endforeach;?>
        </div>
    </div>
</section>
<!-- available servicemen section end -->

<style>
.available-servicemen-box{
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    gap: 8px;
    height: 340px;
}
.available-servicemen-box .service-details,  .service-details a{
    width: 100%;
}
.service-details{
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.productCardImg{
    height: 100%;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>