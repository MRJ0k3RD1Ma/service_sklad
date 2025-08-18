<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ClientCar $model */

$this->title = 'Create Client Car';
$this->params['breadcrumbs'][] = ['label' => 'Client Cars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-car-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
