<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Worker $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="worker-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::class, [
        'mask' => '(99) 999-99-99',
        'options' => [
            'placeholder' => '(90) 123-45-67',
            'class' => 'form-control'
        ]
    ]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group" style="margin-bottom: 33px;">
        <img src="/upload/<?= $model->isNewRecord ? 'default/nophoto.png' : $model->image?>" id="blah" style="height:200px; width:auto;">
    </div>
    <div class="form-group">
        <label>Rasm</label>
        <div class="custom-file">
            <input type="file" name="Worker[image]" id="worker-image" class="custom-file-input">
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
        
        $('#worker-image').change(function() {
          readURL(this);
        });
 
");

?>


