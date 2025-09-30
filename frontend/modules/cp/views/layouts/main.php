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


        <style>
            .pagination a, .pagination span {
                text-decoration: none;
                color: #000;
                float: left;
                padding: 8px 16px;
            }

            .pagination li.active a {
                background-color: #4CAF50;
                color: #FFF;
                border-radius: 5px;
            }
            .pagination a:hover:not(.active) {
                background-color: #DDD;
                border-radius: 5px;
            }
        </style>
    </head>
    <body class="sidebar-light header-white">
    <?php $this->beginBody() ?>






    <?= $this->render('_header'); ?>


    <?= $this->render('_left_sidebar')?>


    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
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
                <div class="mb-30">
                    <div class="pb-20">

                        <?= $content?>

                    </div>
                </div>
            </div>
            <div class="footer-wrap pd-20 mb-20 card-box">
                OKSERVICE.UZ - <a href="http://milliondastur.uz" target="_blank">Dilmurod Allabergenov</a> All rights reserved &copy;<?= date('Y')?>
            </div>
        </div>

    </div>


    <div class="modal" id="md-modalcreate" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Yangi ma'lumot qo'shish</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body md-modalcreate">

                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="md-modalupdate" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title">Ma'lumotlarni yangilash</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body md-modalupdate">

                </div>
            </div>
        </div>
    </div>



    <?php
        $this->registerJs("
            $('.md-btncreate').click(function(){
                var val = $(this).val();
                $('#md-modalcreate').modal('show').find('.modal-body.md-modalcreate').load(val);
            });
             $('.md-btnupdate').click(function(){
                var val = $(this).val();
                $('#md-modalupdate').modal('show').find('.modal-body.md-modalupdate').load(val);
            })
        ");
    ?>

    <?php
    if(Yii::$app->session->hasFlash('error')){
        $txt = Yii::$app->session->getFlash('error');
        $this->registerJs("
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: '{$txt}',
        })
    ");
    }
    if(Yii::$app->session->hasFlash('success')){
        $txt = Yii::$app->session->getFlash('success');
        $this->registerJs("
        Swal.fire({
          icon: 'success',
          title: 'Good job!',
          text: '{$txt}',
        })
    ");
    }

    ?>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage();
