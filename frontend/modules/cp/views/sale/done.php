<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Sale $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="sale-form">

    <?php $form = ActiveForm::begin(); ?>

            <p><b>Mijoz:</b> <?= $model->client->name?></p>
            <p><b>Xizmat:</b> <?= $model->product->name?></p>

            <?= $form->field($model, 'price_per')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'price_worker')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'volume')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'price')->textInput(['maxlength' => true,'disabled'=>true]) ?>

            <?= $form->field($model, 'total_price_worker')->textInput(['maxlength' => true,'disabled'=>true]) ?>


    <div class="form-group">
        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

    $this->registerJs("
        function updatePrice(){
            let pricePer = $('#sale-price_per').val();
            let priceWorker = $('#sale-price_worker').val();
            let volume = $('#sale-volume').val();
            $('#sale-price').val(pricePer*volume);
            $('#sale-total_price_worker').val(priceWorker*volume);            
        }
        $('#sale-price_per').keyup(function(){updatePrice()});
        $('#sale-price_worker').keyup(function(){updatePrice()});
        $('#sale-volume').keyup(function(){updatePrice()});
    ")

?>