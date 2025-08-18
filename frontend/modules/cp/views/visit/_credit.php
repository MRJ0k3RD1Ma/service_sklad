<?php
use yii\widgets\ActiveForm;

$form = ActiveForm::begin()
?>

    <h5><b>Mijoz: </b><?= $model->client->name ?></h5>
    <h5><b>Qarz narxi: </b> <?= $credit->price ?> so'm</h5>

    <?= $form->field($credit,'call_date')->textInput(['type'=>'date']) ?>

    <div class="form-group">
        <button class="btn btn-primary" type="submit">Qarzga yozish</button>
    </div>
<?php ActiveForm::end()?>


