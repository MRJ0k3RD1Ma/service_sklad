<?php
$this->title = "Mahsulot qo`shish";

?>

<!-- header starts -->
<header class="main-header">
    <div class="custom-container">
        <div class="header-panel">
            <a href="<?= Yii::$app->urlManager->createUrl(['/service/default/addproduct','id'=>$visit->id ])?>">
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
            <h3><?= $group->name .' turdagi mahsulotni tanlash'?></h3>
        </div>

        <div class="row g-3">

            <?php foreach ($model as $item):?>

                <div class="col-6">
                    <div class="available-servicemen-box">
                        <a href="<?= Yii::$app->urlManager->createUrl(['/service/default/setproduct','id'=>$visit->id,'group_id'=>$item->id,'goods_id'=>$item->id])?>" class="servicemen-img">
                            <img class="img-fluid image w-100" src="<?php if($item->image != 'default/nophoto.png'){
                                echo "/upload/goods/tmp/{$item->image}";
                            }else{
                                echo "/upload/{$item->image}";
                            } ?>" alt="1">
                        </a>

                        <div class="service-details">
                            <a href="<?= Yii::$app->urlManager->createUrl(['/service/default/setproduct','id'=>$visit->id,'group_id'=>$group->id,'goods_id'=>$item->id])?>">
                                <h5><?= $item->name ?></h5>
                            </a>
                            <a href="<?= Yii::$app->urlManager->createUrl(['/service/default/setproduct','id'=>$visit->id,'group_id'=>$group->id,'goods_id'=>$item->id])?>" class="btn theme-btn">Qo'shish</a>
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
.available-servicemen-box .servicemen-img img{
    height: 223px;
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