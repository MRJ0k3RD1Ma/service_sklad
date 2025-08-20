<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ClientType $model */

$this->title = 'Qo`shish Client Type';
$this->params['breadcrumbs'][] = ['label' => 'Client Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-type-create">

    <div class="card">
        <div class="card-body">
        <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
   

</div>
