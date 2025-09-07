<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Client $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="client-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'phone')->textInput([
                    'maxlength' => true,
                'pattern' => '^\([0-9]{2}\)[0-9]{3}-[0-9]{4}$',
                'placeholder' => '(99)000-0000',
                'title' => 'Telefon raqamini (99)000-0000 formatida kiriting',
                'class' => 'form-control phone-mask'
                ]) ?>

        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'type_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\ClientType::find()->where(['status'=>1])->all(),'id','name')) ?>
            <?= $form->field($model, 'phone_two')->textInput(['maxlength' => true]) ?>

        </div>
    </div>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <div class="form-group" style="margin-bottom: 33px;">
        <img src="/upload/<?= $model->isNewRecord ? 'default/avatar.png' : $model->image?>" id="blah" style="height:200px; width:auto;">
    </div>
    <div class="form-group">
        <label>Rasm</label>
        <div class="custom-file">
            <input type="file" name="Client[image]" id="client-image" class="custom-file-input">
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
        
        $('#client-image').change(function() {
          readURL(this);
        });
        
        
        
        // Telefon raqami uchun mask
        $('.phone-mask').on('input', function(e) {
            let value = e.target.value.replace(/[^\d]/g, '');
            let formattedValue = '';
            
            if (value.length > 0) {
                formattedValue += '(' + value.substring(0, 2);
            }
            if (value.length >= 3) {
                formattedValue += ')' + value.substring(2, 5);
            }
            if (value.length >= 6) {
                formattedValue += '-' + value.substring(5, 9);
            }
            
            // Maksimal uzunlikni cheklash
            if (value.length > 9) {
                formattedValue = formattedValue.substring(0, 12);
            }
            
            e.target.value = formattedValue;
            
            // Validatsiya
            const pattern = /^\([0-9]{2}\)[0-9]{3}-[0-9]{4}$/;
            if (formattedValue && !pattern.test(formattedValue)) {
                e.target.setCustomValidity('Telefon raqamini (99)967-0395 formatida kiriting');
            } else {
                e.target.setCustomValidity('');
            }
        });

        // Backspace uchun maxsus ishlov berish
        $('.phone-mask').on('keydown', function(e) {
            if (e.key === 'Backspace') {
                let value = e.target.value;
                let cursorPos = e.target.selectionStart;
                
                // Agar cursor format belgisida bo'lsa, uni o'tkazib yuborish
                if (cursorPos > 0) {
                    let prevChar = value[cursorPos - 1];
                    if (prevChar === '(' || prevChar === ')' || prevChar === '-') {
                        e.target.selectionStart = cursorPos - 1;
                        e.target.selectionEnd = cursorPos - 1;
                    }
                }
            }
        });

        // Paste hodisasini boshqarish
        $('.phone-mask').on('paste', function(e) {
            e.preventDefault();
            let paste = (e.originalEvent.clipboardData || window.clipboardData).getData('text');
            let numbers = paste.replace(/[^\d]/g, '');
            
            if (numbers.length <= 9) {
                let formattedValue = '';
                if (numbers.length > 0) {
                    formattedValue += '(' + numbers.substring(0, 2);
                }
                if (numbers.length >= 3) {
                    formattedValue += ')' + numbers.substring(2, 5);
                }
                if (numbers.length >= 6) {
                    formattedValue += '-' + numbers.substring(5, 9);
                }
                
                e.target.value = formattedValue;
                e.target.dispatchEvent(new Event('input'));
            }
        });

        // Form submit qilishda validatsiya
        $('form').on('submit', function(e) {
            let isValid = true;
            const pattern = /^\([0-9]{2}\)[0-9]{3}-[0-9]{4}$/;
            
            $('.phone-mask').each(function() {
                if (this.value && !pattern.test(this.value)) {
                    isValid = false;
                    $(this).addClass('is-invalid');
                    if (!$(this).next('.invalid-feedback').length) {
                        $(this).after('<div class=\"invalid-feedback\">Telefon raqamini (99)967-0395 formatida kiriting</div>');
                    }
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').remove();
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                return false;
            }
        });
 
");