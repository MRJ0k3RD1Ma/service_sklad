<?php

use common\models\FornitureWallType;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\FornitureService $model */
/** @var yii\widgets\ActiveForm $form */
?>

<style>
    ul#results,ul#results-product {
        list-style-type: none;
        padding: 0;
        margin: 0;
        margin-top:-20px;
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
    input[type=checkbox], input[type=radio]{
        scale: 1.5;
        margin-left: 20px;
    }
</style>



<div class="forniture-service-form">

    <?php $form = ActiveForm::begin(); ?>


    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'duedate')->textInput(['type'=>'date']) ?>
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
        <div class="col-md-4">
            <?= $form->field($model, 'code')->textInput(['maxlength' => true,'disabled'=>true]) ?>

        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>


        </div>

    </div>


    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'price_agreed')->textInput() ?>

        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'debt')->textInput() ?>

        </div>
        <div class="col-md-4">
            <?= $form->field($model,'payment_id')->dropDownList(ArrayHelper::map(\common\models\Payment::find()->all(),'id','name')) ?>
        </div>
    </div>



    <?= $form->field($model, 'wall_type_id')->radioList(\yii\helpers\ArrayHelper::map(FornitureWallType::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'forniture_id')->radioList(ArrayHelper::map(\common\models\Forniture::find()->all(), 'id', 'name')) ?>


    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'saled_by_id')->dropDownList(ArrayHelper::map(\common\models\User::find()->all(), 'id', 'name')) ?>

        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'ads')->textInput() ?>
        </div>

    </div>

    <?= $form->field($model,'worker_list')->checkboxList(ArrayHelper::map(\common\models\User::find()->all(), 'id', 'name')) ?>


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
            $('#fornitureservice-client_name').val(name);
            $('#fornitureservice-client_phone').val(phone);
            $('#fornitureservice-client_id').val(id);
            $('#results').empty();
        });
        function search(){
            var name = $('#fornitureservice-client_name').val();
            var phone = $('#fornitureservice-client_phone').val();
            $('#fornitureservice-client_id').val(-1);
            if(name.length === 0 && phone.length === 0){
                $('#results').empty();
                $('#fornitureservice-client_id').val(-1);
                return;
            }
            $.get('$url?name='+name+'&phone='+phone).done(function(data){
                $('#results').empty();
                $('#results').append(data);
            })
         }
         $('#fornitureservice-client_name').on('keyup', function() {
            search();
         });
    
        $('#fornitureservice-client_phone').on('keyup', function() {
            search();
        });
        
      
")?>
