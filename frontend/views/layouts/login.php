<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>



    </head>
    <body  class="login-page">
    <?php $this->beginBody() ?>



    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-7">
                    <img src="/design/vendors/images/login-page-img.png" alt="" />
                </div>
                <div class="col-md-6 col-lg-5">

                    <div class="row">
                        <div class="col-md-12 text-center">
                            <img src="/mbos.svg" alt="" style="height: 100px;">

                        </div>
                    </div>
                    <div class="login-box bg-white box-shadow border-radius-10">
                        <div class="login-title">
                            <h2 class="text-center text-primary">Tizimga kirish</h2>
                        </div>
                        <?= $content?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- welcome modal start -->




    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage();
