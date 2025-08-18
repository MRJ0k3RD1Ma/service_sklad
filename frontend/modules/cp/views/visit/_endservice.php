<?php
/* @var $visit \common\models\Visit*/
/* @var $model \common\models\ClientCar*/
use yii\widgets\ActiveForm;
$form = ActiveForm::begin(['action'=>Yii::$app->urlManager->createUrl(['/cp/visit/endservice','id'=>$visit->id])]);
?>

<?= $form->field($model,'run')?>
<?= $form->field($model,'call_date')->textInput(['type'=>'date'])?>
<?= $form->field($model,'ads')->textarea()?>

<button class="btn btn-success" type="submit">Xizmat ko'rsatishni yakunlash</button>

<?php ActiveForm::end()?>
