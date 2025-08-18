<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CustomType */
/* @var $setting common\models\Custom[] */

$this->title = 'Sozlamalar: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Boshqa sozlamalar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>


<div class="custom-type-setting">
    <div class="card">
        <div class="card-body">
            <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

            <?php foreach ($setting as $item):?>

                <?= $this->render('gen/_'.$item->value_type,['model'=>$item,'form'=>$form]); ?>

            <?php endforeach;?>


            <div class="form-group mt-3">
                <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>