<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\ComeProduct $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="come-form">
    <style>
        ul.results,ul.results-product {
            list-style-type: none;
            padding: 0;
            margin: 0;
            position: absolute; /* UL elementini sahifada belgilangan joyga joylashtirish */
            top: 40px; /* Input maydonidan pastga joylashtirish */
            left: 0;
            width: 100%;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 999;
        }
        ul.results li,ul.results-product li {
            padding: 8px;
            border-bottom: 1px solid #000 !important;
        }
        ul.results li:hover,ul.results-product li:hover {
            background-color: #1b00ff !important;
        }
    </style>
    <?php $form = ActiveForm::begin(); ?>

    <div class="hidden" hidden style="display: none">
        <?= $form->field($model,'goods_id') ?>
    </div>
    <?= $form->field($model,'name')->textInput()?>
    <ul id="results-product">

    </ul>
    <?= $form->field($model,'ostatka')->textInput(['disabled'=>true])?>

    <?= $form->field($model,'cnt')->textInput()?>
    <?= $form->field($model,'price')->textInput()?>

    <?= $form->field($model,'cnt_price')->textInput(['disabled'=>true])?>

    <div class="form-group">
        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$url_product = Yii::$app->urlManager->createUrl(['/cp/gen/getproduct']);
$url_scan = Yii::$app->urlManager->createUrl(['/cp/gen/scan']);

$this->registerJs(<<<JS
     $(document).ready(function() {
        $('#md-modalcreate').on('hidden.bs.modal', function () {
          location.reload(); // Page reloads when the modal is closed or hidden
        });
      });
    function searchproduct(){
        var name = $('#comeproduct-name').val();
        $('#comeproduct-goods_id').val(-1);
        if(name.length === 0){
            $('#results-product').empty();
            return;
        }
        $.get('$url_product?name='+name).done(function(data){
            $('#results-product').empty();
            $('#results-product').append(data);
        })
     }
     $('#comeproduct-name').on('keyup',function(){
         searchproduct();
     });

    $('form').on('submit', function(event) {
        if (event.originalEvent.submitter && event.originalEvent.submitter.type === 'submit') {
          // Submit tugmasi bosilganda formani yuboradi
          return true;
        }
        event.preventDefault();  // Enter tugmasi bosilganda formani yubormaydi
      });
    
      // Enter tugmasini bosganda formani yubormaslik
      $('form').on('keydown', function(event) {
        if (event.key === 'Enter') {
          event.preventDefault();  // Enter tugmasini bosishdan saqlaydi
        }
      });
  
       $('#results-product').on('click', 'li', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var price = $(this).data('price');
        var ostatka = $(this).data('ostatka');
        
        $('#comeproduct-goods_id').val(id);
        $('#comeproduct-name').val(name);
        $('#comeproduct-price').val(price);
        $('#comeproduct-ostatka').val(ostatka);
        $('#comeproduct-cnt').val(1);
        $('#comeproduct-cnt_price').val(price);
        $('#results-product').empty();
    });
      
            function changeprice(){
                var cnt = $('#comeproduct-cnt').val();
                var price = $('#comeproduct-price').val();
                var cnt_price = cnt * price;
                $('#comeproduct-cnt_price').val(cnt_price);
            }
            $('#comeproduct-cnt').on('keyup', function() {
                changeprice();
            });
            $('#comeproduct-price').on('keyup', function() {
                changeprice();
            });
     let scannedData = '';
     let timeout;
     
     $(document).on('keydown',function(event){
        clearTimeout(timeout);
        
        if (event.key === 'Enter') {
            // Enter tugmasi bosilganda skaner ma'lumotni uzatish tugallanganini anglatadi
            $.get('{$url_scan}?code='+scannedData).done(function(data){
                if(data != -1){
                    data = JSON.parse(data);
                    var id = data.id;
                    var name = data.name;
                    var price = data.price;
                    var ostatka = data.ostatka;
                    
                    $('#comeproduct-goods_id').val(id);
                    $('#comeproduct-name').val(name);
                    $('#comeproduct-price').val(price);
                    $('#comeproduct-ostatka').val(ostatka);
                    $('#comeproduct-cnt').val(1);
                    $('#comeproduct-cnt_price').val(price);
                    
                    $('#comeproduct-cnt').focus();
                }
            });
            scannedData = ''; // Kiritilgan ma'lumotni tozalash
        } else {
            scannedData += event.key; // Har bir tugmachani ketma-ketlikda qo'shish
           
        }
        
        // Timeout bilan kiritishni reset qilish
        timeout = setTimeout(() => {
            scannedData = ''; // Ma'lumotlar 500 ms ichida kirmasa, tozalash
        }, 500);
    })  


JS)
?>
