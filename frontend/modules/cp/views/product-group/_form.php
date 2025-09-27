<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\ProductGroup $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-group-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group" style="margin-bottom: 33px;">
        <img src="/upload/<?= $model->isNewRecord ? 'default/nophoto.png' : $model->image?>" id="blah" style="height:200px; width:auto;">
    </div>
    <div class="form-group">
        <label>Rasm</label>
        <div class="custom-file">
            <input type="file" name="ProductGroup[image]" id="user-image" class="custom-file-input">
            <label class="custom-file-label">Rasmni tanlang</label>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
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
        
        $('#user-image').change(function() {
          readURL(this);
        });
 
");