<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Sale $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="sale-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'date')->textInput(['type'=>'date']) ?>

            <?= $form->field($model, 'client_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\Client::find()->where(['status'=>1])->all(),'id',function($d){
                return $d->name.' - '.$d->phone;
            }),['prompt'=>'Mijozni tanlang']) ?>



            <?= $form->field($model, 'worker_id')->dropDownList(\yii\helpers\ArrayHelper::map(
                    \common\models\Worker::find()->where(['status'=>1])->all(),'id','name'
            ),['prompt'=>'Brigadirni tanlang']) ?>

            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">

            <?= $form->field($model, 'product_id')->dropDownList(\yii\helpers\ArrayHelper::map(
                \common\models\Product::find()->where(['status'=>1])->all(),'id','name'
            ),['prompt'=>'Xizmatni tanlang']) ?>

            <?= $form->field($model, 'price_per')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'volume_estimated')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'price')->textInput(['maxlength' => true,'disabled'=>true]) ?>

        </div>
    </div>





    <div class="form-group">
        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$url = Yii::$app->urlManager->createUrl(['/cp/sale/getproductprice']);
$this->registerJs("
    function updatePrice(){
        let price = $('#sale-price_per').val();
        let volume = $('#sale-volume_estimated').val();
        $('#sale-price').val(price * volume);
    }
    $('#sale-product_id').change(function(){
        $.get('{$url}?id='+$('#sale-product_id').val()).done(function(data){
            $('#sale-price_per').val(data);
            updatePrice();
        })
    });
    $('#sale-volume_estimated').keyup(function(){
        updatePrice();
    })
")

?>