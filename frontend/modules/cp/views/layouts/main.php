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
    <body class="sidebar-light header-white">
    <?php $this->beginBody() ?>






    <?= $this->render('_header'); ?>


    <?= $this->render('_left_sidebar')?>


    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <?php if(Yii::$app->controller->id != 'site' and Yii::$app->controller->action->id != 'index'){?>
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="title">
                                <h4><?= $this->title ?></h4>
                            </div>

                            <?= Breadcrumbs::widget([
                                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                            ]) ?>
                        </div>
                    </div>
                </div>
    <?php }?>
                <div class="mb-30">
                    <div class="pb-20">

                        <?= $content?>

                    </div>
                </div>
            </div>
            <div class="footer-wrap pd-20 mb-20 card-box">
                OSONPAY - <a href="http://OSONPAY.MEDIA" target="_blank">OSONPAY.MEDIA</a> All rights reserved &copy;<?= date('Y')?>
            </div>
        </div>

    </div>



    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage();
