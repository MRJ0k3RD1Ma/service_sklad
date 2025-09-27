<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Sale $model */

$this->title = 'Shartnoma Qo`shish';
$this->params['breadcrumbs'][] = ['label' => 'Shartnomalar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sale-create">

    <div class="card">
        <div class="card-body">
        <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
   

</div>
