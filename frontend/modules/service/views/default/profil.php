<?php
/** @var yii\web\View $this */
/** @var common\models\User $model */

/** @var yii\widgets\ActiveForm $form */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Profil', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- header starts -->
<header class="main-header">
    <div class="custom-container">
        <div class="header-panel">
            <a href="<?= Yii::$app->urlManager->createUrl(['/service/'])?>">
                <i class="iconsax icon-btn" data-icon="chevron-left"> </i>
            </a>
            <h3>Profil sozlamalari</h3>
        </div>
    </div>
</header>
<!-- header end -->

    <script>
        /*=====================
    Image Change js
==========================*/
        var loadFile = function (event) {
            var image = document.getElementById("output");
            image.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>
<!-- profile section starts -->

<section class="section-b-space section-lg-t-space">
    <div class="custom-container">
        <div class="profile-background">
            <img class="img-fluid profile-bg" src="/mobil/img/profile-bg.png" alt="profile-bg">
            <div class="profile-part mt-3">
                <div class="profile-image">
                    <img class="img-fluid profile-pic" id="output" src="/upload/<?= $model->isNewRecord ? 'default/avatar.png' : $model->image ?>"
                         alt="11">
                    <label for="file"><i class="iconsax edit-icon" data-icon="edit-2"></i></label>

                </div>
            </div>
        </div>
        <?php $form = ActiveForm::begin(['options'=>['class'=>'mt-0 rounded-top-0 auth-form','enctype'=>'multipart/form-data']]); ?>
        <input id="file" type="file" hidden="hidden" style="display: none" name="User[image]" onchange="loadFile(event)">

            <div class="form-group mt-0">
                <label class="form-label mb-2" for="user-name">Ismingiz:</label>
                <div class="form-input">
                    <input type="text" name="User[name]" class="form-control without-icon" id="user-name" value="<?= $model->name?>"
                           placeholder="Ismingizni kiriting">
                </div>
            </div>
        <div class="form-group">
            <label class="form-label mb-2" for="user-phone">Telefon:</label>
            <div class="form-input">
                <input type="text" name="User[phone]" class="form-control without-icon" id="user-phone"
                       value="<?= $model->phone?>" placeholder="Telefoningizni kiriting..">
            </div>
        </div>
            <div class="form-group">
                <label class="form-label mb-2" for="user-username">Login</label>
                <div class="form-input">
                    <input type="text" name="User[username]" class="form-control without-icon" id="user-username"
                           value="<?= $model->username?>" placeholder="Loginingizni kiriting..">
                </div>
            </div>
        <div class="form-group">
            <label class="form-label mb-2" for="user-password">Parol</label>
            <div class="form-input">
                <input type="text" name="User[password]" class="form-control without-icon" id="user-password"
                       value="<?= $model->password?>" placeholder="Parolingizni kiriting..">
            </div>
        </div>


            <button type="submit"  class="btn theme-btn w-100 auth-btn">O'zgarishlarni saqlash</button>
        <?php ActiveForm::end(); ?>

    </div>
</section>
<!-- profile section end -->


<?php

$this->registerJs("
                            readURL = function (input) {
                            console.log(input);
                              if (input.files && input.files[0]) {
                                var reader = new FileReader();
                                
                                reader.onload = function(e) {
                                  $('#blah').attr('src', e.target.result);
                                }
                                
                                reader.readAsDataURL(input.files[0]);
                              }
                            }
                            
                            $('#user-image').change(function() {
                              readURL(this);
                            });
                    
                    "); ?>