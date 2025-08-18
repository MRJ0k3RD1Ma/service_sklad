<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\SupplerReturn $model */

$this->title = 'Create Suppler Return';
$this->params['breadcrumbs'][] = ['label' => 'Suppler Returns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suppler-return-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
