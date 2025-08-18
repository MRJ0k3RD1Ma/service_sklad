<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Suppler $model */

$this->title = 'Create Suppler';
$this->params['breadcrumbs'][] = ['label' => 'Supplers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suppler-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
