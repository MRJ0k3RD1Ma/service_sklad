<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Worker $model */

$this->title = 'Qo`shish Worker';
$this->params['breadcrumbs'][] = ['label' => 'Workers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="worker-create">

    <div class="card">
        <div class="card-body">
        <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
   

</div>
