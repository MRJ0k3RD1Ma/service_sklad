<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Goods $model */
/** @var yii\widgets\ActiveForm $form */
?>
    <style>
        #goods-price_type label{
            display: block;
        }
    </style>
<div class="goods-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'barcode')->textInput(['maxlength' => true]) ?>

        </div>
    </div>

    <p><span class="text text-danger">*</span> Barcode Ochiq qoldirilsa dasturning o'zi automatik to'ldiradi</p>

    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'group_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\GoodsGroup::find()->where(['status'=>1,'type'=>1])->all(),'id','name')) ?>

        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'unit_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\GoodsUnit::find()->all(),'id','name')) ?>

        </div>
    </div>




    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'price_type')->radioList(Yii::$app->params['price_type'], [
                'item' => function ($index, $label, $name, $checked, $value) {
                    return '<div class="radio" style="margin-top:15px;">' .
                        '<label>' .
                        '<input type="radio" name="' . $name . '" value="' . $value . '"' . ($checked ? ' checked' : '') . '>' .
                        $label .
                        '</label>' .
                        '</div>';
                }
            ])?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'price_come')->textInput(['maxlength' => true]) ?>

        </div>
    </div>


    <?php if($model->isNewRecord){?>

        <?= $form->field($model,'remainder_first')->textInput()->label('Skladda mavjud')?>

    <?php }?>

    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label>Rasm</label>
                <div class="custom-file">
                    <input type="file" name="Goods[image]" id="goods-image" class="custom-file-input">
                    <label class="custom-file-label">Rasmni tanlang</label>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group" style="margin-bottom: 33px;">
                <img src="/upload/<?= $model->isNewRecord ? 'default/nophoto.png' : (($model->image == 'default/nophoto.png') ? 'default/nophoto.png' : 'goods/'.$model->image )?>" id="blah" style="height:200px; width:auto;">
            </div>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



<?php
$this->registerJs("

     let scannedData = '';
     let timeout;
    
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
        $(document).on('keydown',function(event){
            clearTimeout(timeout);
            
            if (event.key === 'Enter') {
                // Enter tugmasi bosilganda skaner ma'lumotni uzatish tugallanganini anglatadi
                
                $('#goods-barcode').val(scannedData);
                console.log('Scanned Data:', scannedData);
                scannedData = ''; // Kiritilgan ma'lumotni tozalash
            } else {
                scannedData += event.key; // Har bir tugmachani ketma-ketlikda qo'shish
               
            }
            
            // Timeout bilan kiritishni reset qilish
            timeout = setTimeout(() => {
                scannedData = ''; // Ma'lumotlar 500 ms ichida kirmasa, tozalash
            }, 200);
        })
");