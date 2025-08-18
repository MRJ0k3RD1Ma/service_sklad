<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Payout $model */

$this->title = 'Create Payout';
$this->params['breadcrumbs'][] = ['label' => 'Payouts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payout-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
