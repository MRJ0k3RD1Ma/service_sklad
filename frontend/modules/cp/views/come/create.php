<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Come $model */

$this->title = 'Create Come';
$this->params['breadcrumbs'][] = ['label' => 'Comes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="come-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
