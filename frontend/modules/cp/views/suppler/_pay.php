<?php
/* @var $model \common\models\SupplerPaid*/
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin()?>

    <?= $form->field($model,'date')->textInput(['type'=>'date'])?>
    <?= $form->field($model,'price')?>
    <?= $form->field($model,'payment_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\Payment::find()->all(),'id','name'))?>

    <button type="submit" class="btn btn-success">Saqlash</button>
<?php ActiveForm::end()?>
