<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\SupplerPaid $model */

$this->title = 'Create Suppler Paid';
$this->params['breadcrumbs'][] = ['label' => 'Suppler Paids', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suppler-paid-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
