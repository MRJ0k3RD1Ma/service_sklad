<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = "Chek ma'lumotlari";
/** @var yii\web\View $this */
/** @var common\models\Setting $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="setting-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'qr_url')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'is_logo')->checkbox(['value'=>1,'style'=>'margin-top:15px;']) ?>

                    <?= $form->field($model, 'logo_size')->textInput(['disabled'=>$model->is_logo ? false : true]) ?>

                </div>
                <div class="col-md-4">

                    <div class="form-group" style="margin-bottom: 33px;">
                        <img src="/upload/<?= !$model->logo ? 'default/nophoto.png' : 'logo/'.$model->logo?>" id="blah" style="height:200px; width:auto;">
                    </div>
                    <div class="form-group">
                        <label>Rasm</label>
                        <div class="custom-file">
                            <input type="file" name="Setting[logo]" <?= $model->is_logo==0 ? 'disabled' : ''?> id="setting-logo" class="custom-file-input">
                            <label class="custom-file-label">Rasmni tanlang</label>
                        </div>
                    </div>


                </div>
            </div>



            <div class="form-group">
                <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>



    <?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJs("
        function readURL(input) {
          if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
              $('#blah').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
          }
        }
        
        $('#setting-logo').change(function() {
          readURL(this);
        });
 
        $('#setting-is_logo').change(function() {
            if($(this).is(':checked')) {
                $('#setting-logo_size').prop('disabled', false);
                $('#setting-logo').prop('disabled', false);
            } else {
                $('#setting-logo_size').prop('disabled', true);
                $('#setting-logo').prop('disabled', true);
            }
        });
 
 
");