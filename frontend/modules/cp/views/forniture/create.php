<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Forniture $model */

$this->title = 'Create Forniture';
$this->params['breadcrumbs'][] = ['label' => 'Fornitures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forniture-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
