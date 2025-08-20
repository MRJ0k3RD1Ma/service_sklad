<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Paid $model */

$this->title = 'Qo`shish Paid';
$this->params['breadcrumbs'][] = ['label' => 'Paids', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paid-create">

    <div class="card">
        <div class="card-body">
        <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
   

</div>
