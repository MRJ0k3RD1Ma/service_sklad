<?php
use yii\widgets\ActiveForm;
$this->title = "Mahsulotlarni skladga qabul qilish";

/* @var $model \common\models\Come*/
?>
<style>
    ul#results,ul#results-product {
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
    ul#results li,ul#results-product li {
        padding: 8px;
        border-bottom: 1px solid #000 !important;
    }
    ul#results li:hover,ul#results-product li:hover {
        background-color: #1b00ff !important;
    }
</style>
<div class="card">
    <div class="card-body">

        <?php $form = ActiveForm::begin()?>

        <div class="row">
            <div class="col-md-2">
                <?= $form->field($model,'date')->textInput(['type'=>'date'])?>
            </div>
            <div class="col-md-1">
                <?= $form->field($model,'nakladnoy')->textInput()->label('Nakladnoy')?>
            </div>
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model,'suppler_name')->textInput()?>
                        <div hidden aria-hidden="true" style="display: none">
                            <?= $form->field($model,'suppler_id')->textInput(['value'=>-1])?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model,'suppler_phone')->textInput()?>
                    </div>
                </div>
                <div class="col-md-12">
                    <ul id="results">

                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <?= $form->field($model,'comment')?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <?= $form->field($model,'pro[product]')->label("Mahsulot nomi")?>
                <div hidden aria-hidden="true" style="display: none">
                    <?= $form->field($model,'pro[id]')->textInput(['value'=>-1])->label(false)?>
                </div>
                <ul id="results-product">

                </ul>
            </div>
            <div class="col-md-2">
                <?= $form->field($model,'pro[ostatka]')->textInput(['value'=>0,'disabled'=>true])->label("Qoldiq")?>
            </div>
            <div class="col-md-2">
                <?= $form->field($model,'pro[cnt]')->label("Soni")?>
            </div>
            <div class="col-md-2">
                <?= $form->field($model,'pro[price]')->label("Narxi")?>
            </div>
            <div class="col-md-2">
                <?= $form->field($model,'pro[cnt_price]')->textInput(['disabled'=>true,'value'=>0])->label("Umumiy narx")?>
            </div>
            <div class="col-md-1">
                <button class="btn btn-primary" type="button" style="margin-top: 18px;" id="plusbtn"><span class="fa fa-plus"></span></button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kodi</th>
                                <th>Nomi</th>
                                <th>Soni</th>
                                <th>Narxi</th>
                                <th>Umumiy narx</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="plustable">
                            <?php if(Yii::$app->session->has('income')):?>
                                <?php foreach (Yii::$app->session->get('income') as $key=>$item):?>
                                    <tr>
                                        <td><?= $key+1?></td>
                                        <td><?= $item['barcode']?></td>
                                        <td><?= $item['name'] ?></td>
                                        <td><?= $item['cnt'] ?></td>
                                        <td><?= $item['price'] ?></td>
                                        <td><?= $item['cnt_price'] ?></td>
                                        <td><button class="btn btn-danger removerbtn" type="button" value="<?= $item['id']?>"><span class="fa fa-trash"></span></button></td>
                                    </tr>
                                <?php endforeach;?>
                            <?php endif;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-success" type="submit"><span class="fa fa-save"></span> Saqlash</button>
            </div>
        </div>


        <?php ActiveForm::end()?>


    </div>
</div>


<?php
$url = Yii::$app->urlManager->createUrl(['/cp/gen/getsuppler']);
$url_product = Yii::$app->urlManager->createUrl(['/cp/gen/getproduct']);
$url_set = Yii::$app->urlManager->createUrl(['/cp/gen/incomeorder']);
$url_scan = Yii::$app->urlManager->createUrl(['/cp/gen/scan']);
$url_remove = Yii::$app->urlManager->createUrl(['/cp/gen/incomeorderremove']);
$this->registerJs(<<<JS
        
      $('#plusbtn').click(function(){
          if($('#come-pro-product').length>0 && $('#come-pro-id').val()!=-1 && $('#come-pro-price').val() >= 0 && $('#come-pro-cnt').val() > 0 && $('#come-pro-price').val()){
              $.get('{$url_set}?id='+$('#come-pro-id').val()+'&name='+$('#come-pro-product').val()+'&cnt='+$('#come-pro-cnt').val()+'&price='+$('#come-pro-price').val()).done(function(data){
                  data = JSON.parse(data);
                  $('#plustable').empty();
                  Object.values(data).forEach(function(item,index){
                      var p = "<tr>";
                      p += "<td>"+(index+1)+"</td>";
                      p += "<td>"+item.barcode+"</td>";
                      p += "<td>"+item.name+"</td>";
                      p += "<td>"+item.cnt+"</td>";
                      p += "<td>"+item.price+"</td>";
                      p += "<td>"+item.cnt_price+"</td>";
                      p += "<td><button class='btn btn-danger removerbtn' type='button' value='"+item.id+"'><span class='fa fa-trash'></span></button></td>";
                      p += "</tr>";
                      $('#plustable').append(p);
                  })
              });
              $('#come-pro-product').val('');
              $('#come-pro-id').val(-1);
              $('#come-pro-price').val('');
              $('#come-pro-cnt').val('');
              $('#come-pro-cnt_price').val('');
          }
          
      })


     function search(){
        var name = $('#come-suppler_name').val();
        var phone = $('#come-suppler_phone').val();
        $('#come-suppler_id').val(-1);
        if(name.length === 0 && phone.length === 0){
            $('#results').empty();
            $('#come-suppler_id').val(-1);
            return;
        }
        $.get('$url?name='+name+'&phone='+phone).done(function(data){
            $('#results').empty();
            $('#results').append(data);
        })
     }
     
     function searchproduct(){
        var name = $('#come-pro-product').val();
        $('#come-pro-id').val(-1);
        if(name.length === 0){
            $('#results-product').empty();
            return;
        }
        $.get('$url_product?name='+name).done(function(data){
            $('#results-product').empty();
            $('#results-product').append(data);
        })
     }
     $('#come-pro-product').on('keyup',function(){
         searchproduct();
     });


     $('#come-suppler_name').on('keyup', function() {
        search();
     });

    $('#come-suppler_phone').on('keyup', function() {
        search();
    });
    
    $('#results').on('click', 'li', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var phone = $(this).data('phone');
        $('#come-suppler_name').val(name);
        $('#come-suppler_phone').val(phone);
        $('#come-suppler_id').val(id);
         $('#results').empty();
    });
    
    $('#results-product').on('click', 'li', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var price = $(this).data('price');
        var ostatka = $(this).data('ostatka');
        
        $('#come-pro-id').val(id);
        $('#come-pro-product').val(name);
        $('#come-pro-price').val(price);
        $('#come-pro-ostatka').val(ostatka);
        $('#come-pro-cnt').val(1);
        $('#come-pro-cnt_price').val(price);
        $('#results-product').empty();
    });
    
    function changeprice(){
        var cnt = $('#come-pro-cnt').val();
        var price = $('#come-pro-price').val();
        var cnt_price = cnt * price;
        $('#come-pro-cnt_price').val(cnt_price);
    }
    $('#come-pro-cnt').on('keyup', function() {
        changeprice();
    });
    $('#come-pro-price').on('keyup', function() {
        changeprice();
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
  
  $('.removerbtn').click(function(){
      var id = $(this).val();
      $.get('$url_remove?id='+id).done(function(data){
          data = JSON.parse(data);
          $('#plustable').empty();
          Object.values(data).forEach(function(item,index){
              var p = "<tr>";
              p += "<td>"+(index+1)+"</td>";
              p += "<td>"+item.barcode+"</td>";
              p += "<td>"+item.name+"</td>";
              p += "<td>"+item.cnt+"</td>";
              p += "<td>"+item.price+"</td>";
              p += "<td>"+item.cnt_price+"</td>";
              p += "<td><button class='btn btn-danger removerbtn' type='button' value='"+item.id+"'><span class='fa fa-trash'></span></button></td>";
              p += "</tr>";
              $('#plustable').append(p);
          })
      })
  })
  
  
  
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
                    
                    $('#come-pro-id').val(id);
                    $('#come-pro-product').val(name);
                    $('#come-pro-price').val(price);
                    $('#come-pro-ostatka').val(ostatka);
                    $('#come-pro-cnt').val(1);
                    $('#come-pro-cnt_price').val(price);
                    
                    $('#come-pro-cnt').focus();
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
JS);