<?php
$this->title = "Mahsulot qo`shish";

use yii\widgets\ActiveForm;

?>

<!-- header starts -->
<header class="main-header">
    <div class="custom-container">
        <div class="header-panel">
            <a href="<?= Yii::$app->urlManager->createUrl(['/service/default/view', 'id' => $visit->id]) ?>">
                <i class="iconsax icon-btn" data-icon="chevron-left"> </i>
            </a>
            <h3><?= $visit->car->number ?> <span class="text text-danger">(<?= $visit->car->model ?>)</span></h3>
        </div>
    </div>
</header>
<!-- header end -->
<!-- available servicemen section starts -->
<section class="section-b-space" style="padding-top:80px;">
    <div class="custom-container">
        <div class="title">
            <h3><?= $goods->name . ' turdagi mahsulotni qo`shish' ?></h3>
        </div>

        <div class="row g-3">

            <div class="col-12">
                <div class="available-servicemen-box">
                    <a href="#" class="servicemen-img">
                        <img class="img-fluid image w-100" src="<?php if ($goods->image != 'default/nophoto.png') {
                            echo "/upload/goods/tmp/{$goods->image}";
                        } else {
                            echo "/upload/{$goods->image}";
                        } ?>" alt="1">
                    </a>

                    <div class="service-details">
                        <h5><?= $goods->name ?></h5>
                        <p style="font-size:18px;"><b>Narxi: <?= number_format($goods->price, 0, ' ', ' ') ?> so'm</b>
                        <p style="font-size:18px;"><b>Umumiy narxi: <span id="cntprice"><?= $goods->price ?></span> so'm</b></p>
                        </p>
                        <?php $form = ActiveForm::begin() ?>
                        <div class="cardCountButton">

                            <div class="cardCoutn">
                                <button type="button" class="disBtn">-</button>
                                <input type="number" class="form-control" value="<?= $model->cnt?>" id="saleproduct-cnt" name="SaleProduct[cnt]"  style="height: 60px; padding: 10px 20px; font-size: 20px;">
                                <button type="button" class="addBtn">+</button>
                            </div>

                            <button type="submit" class="btn theme-btn">Qo'shish</button>
                        </div>

                        <?php ActiveForm::end() ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- available servicemen section end -->

<?php
    $this->registerJs("
        const price = {$goods->price};
        function change(a){
            let cnt = $('#saleproduct-cnt').val();
            cnt = parseInt(cnt)+ parseInt(a);
            console.log(cnt);
            console.log(a);
            if(cnt <= 1){
                cnt = 1;
            }
            $('#saleproduct-cnt').val(cnt);
            $('#cntprice').text(cnt * price)
        }
        $('.addBtn').click(function(){
            change(1);
        });
        
        $('.disBtn').click(function(){
           
            change(-1);
        });
    ")
?>


<style>
    .available-servicemen-box {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
        height: auto;
    }

    .available-servicemen-box .service-details, .service-details a {
        width: 100%;
    }

    .service-details {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .productCardImg {
        height: 100%;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .cardCoutn {
        display: flex;
        justify-content: space-between;
        width: 100%;
        align-items: center;
        gap: 10px;
        height: 60px;
    }

    .cardCoutn button {
        text-align: center;
        height: 60px;
        width: 130px;
        border: none;
        border-radius: 6px;
        background: #007BFF;
        color: #FFFFFF;
    }
    .cardCountButton{
        display: flex;
        flex-direction: column;
        gap: 40px;
    }
</style>