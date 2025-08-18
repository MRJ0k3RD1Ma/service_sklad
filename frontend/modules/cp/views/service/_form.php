<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Goods $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="goods-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'barcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'group_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\GoodsGroup::find()->where(['status'=>1,'type'=>2])->all(),'id','name')) ?>

    <?= $form->field($model, 'unit_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\GoodsUnit::find()->all(),'id','name')) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price_come')->textInput(['maxlength' => true]) ?>


    <div class="form-group" style="margin-bottom: 33px;">
        <img src="/upload/<?= $model->isNewRecord ? 'default/nophoto.png' : 'goods/tmp/'.$model->image?>" id="blah" style="height:200px; width:auto;">
    </div>
    <div class="form-group">
        <label>Rasm</label>
        <div class="custom-file">
            <input type="file" name="Goods[image]" id="goods-image" class="custom-file-input">
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
        
        $('#goods-image').change(function() {
          readURL(this);
        });
 
");