<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\FornitureWallType $model */

$this->title = 'Create Forniture Wall Type';
$this->params['breadcrumbs'][] = ['label' => 'Forniture Wall Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forniture-wall-type-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
