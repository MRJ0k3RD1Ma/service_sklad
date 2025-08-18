<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Visit $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="visit-form">
    <style>
        ul#results,ul#results-product {
            list-style-type: none;
            padding: 0;
            margin: 0;
            position: absolute; /* UL elementini sahifada belgilangan joyga joylashtirish */
            top: 0; /* Input maydonidan pastga joylashtirish */
            left: 0;
            width: 100%;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 999;
        }
        ul#results li, ul#results-product li {
            padding: 8px !important;
            border-bottom: 1px solid #000 !important;
        }
        ul#results li:hover,ul#results-product li:hover {
            background-color: #acacac !important;
        }
    </style>
    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <div class="row">

    <div class="col-md-9">
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'date')->textInput(['type'=>'date']) ?>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model,'client_name')->textInput()?>
                        <div hidden aria-hidden="true" style="display: none">
                            <?= $form->field($model,'client_id')->textInput(['value'=>-1])?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model,'client_phone')->textInput()?>
                    </div>
                </div>
                <div class="col-md-12">
                    <ul id="results">

                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model,'car_number')->textInput(['style'=>'text-transform:uppercase'])?>
                        <div hidden aria-hidden="true" style="display: none">
                            <?= $form->field($model,'car_id')->textInput(['value'=>-1])?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model,'car_model')->textInput(['style'=>'text-transform:uppercase'])?>
                    </div>
                </div>
                <div class="col-md-12">
                    <ul id="results-product">

                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'car_run')->textInput() ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'call_date')->textInput(['type'=>'date']) ?>
            </div>
            <div class="col-md-8">
                <?= $form->field($model,'ads')->textInput()?>
            </div>
        </div>
    </div>

        <div class="col-md-3">
            <div class="form-group" style="margin-bottom: 10px;">
                <img src="/upload/<?= $model->isNewRecord ? 'default/avatar.png' : $model->image?>" id="blah" style="height:150px; width:auto;">
            </div>
            <div class="form-group">
                <label>Rasm</label>
                <div class="custom-file">
                    <input type="file" name="Visit[image]" id="visit-image" class="custom-file-input">
                    <label class="custom-file-label">Rasmni tanlang</label>
                </div>
            </div>
        </div>

    </div>

    <?= $form->field($model,'user_id')->radioList(\yii\helpers\ArrayHelper::map(\common\models\User::find()->where(['status'=>1])->andWhere('role_id in (50,60)')->all(),'id','name'))?>

    <div class="form-group">
        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$url = Yii::$app->urlManager->createUrl(['/cp/gen/getclient']);
$url_car = Yii::$app->urlManager->createUrl(['/cp/visit/searchcar']);

$this->registerJs("
        $('#results').on('click', 'li', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var phone = $(this).data('phone');
            var image = $(this).data('image');
            $('#visit-client_name').val(name);
            $('#visit-client_phone').val(phone);
            $('#visit-client_id').val(id);
            if(image){
                $('#blah').attr('src', '/upload/'+image);
            }else{
                $('#blah').attr('src', '/upload/default/avatar.png');
            }
            $('#results').empty();
        });
        function search(){
            var name = $('#visit-client_name').val();
            var phone = $('#visit-client_phone').val();
            $('#visit-client_id').val(-1);
            if(name.length === 0 && phone.length === 0){
                $('#results').empty();
                $('#visit-client_id').val(-1);
                return;
            }
            $.get('$url?name='+name+'&phone='+phone).done(function(data){
                $('#results').empty();
                $('#results').append(data);
            })
         }
         $('#visit-client_name').on('keyup', function() {
            search();
         });
    
        $('#visit-client_phone').on('keyup', function() {
            search();
        });
        
        function searchcar(){
            var number = $('#visit-car_number').val();
            var client_id = $('#visit-client_id').val();
            $('#visit-car_id').val(-1);
            if(number.length === 0 || client_id == -1){
                $('#results-product').empty();
                $('#visit-car_id').val(-1);
                return;
            }
            $.get('$url_car?number='+number+'&client_id='+client_id).done(function(data){
                $('#results-product').empty();
                $('#results-product').append(data);
            })
         }
        
        $('#results-product').on('click', 'li', function() {
            var id = $(this).data('id');
            var number = $(this).data('number');
            var model = $(this).data('model');
            var run = $(this).data('run');
            $('#visit-car_number').val(number);
            $('#visit-car_model').val(model);
            $('#visit-car_run').val(run);
            $('#visit-car_id').val(id);
            $('#results-product').empty();
        });
        $('#visit-car_number').on('keyup', function() {
            searchcar();
         });
    
      
")?>

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
        
        $('#visit-image').change(function() {
          readURL(this);
        });
 
");
