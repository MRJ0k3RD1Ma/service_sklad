<?php
/* @var $model \common\models\FornitureService */
?>


<div class="card-order">
    <h2><a href="<?= Yii::$app->urlManager->createUrl(['/cp/forniture-service/view','id'=>$model->id])?>">Buyurtma #<?= $model->code?></a></h2>
    <div class="item">
        <span class="field-name">Yetkazish sanasi:</span>
        <span class="field-value"><?= $model->duedate?></span>
    </div>
    <div class="item">
        <span class="field-name">Buyurtmachi:</span>
        <span class="field-value"><a href="<?= Yii::$app->urlManager->createUrl(['/cp/client/view','id'=>$model->id])?>"><?= $model->client->name?></a></span>
    </div>
    <div class="item">
        <span class="field-name">Buyurtma turi:</span>
        <span class="field-value"><?= $model->forniture->name ?></span>
    </div>
    <div class="item">
        <span class="field-name">Kelishilgan narx:</span>
        <span class="field-value"><?= number_format($model->price_agreed,0,' ',' ')?> so'm</span>
    </div>
    <div class="item">
        <span class="field-name">Ustalar soni:</span>
        <span class="field-value"><?= $model->cntWorker ?> nafar</span>
    </div>
    <div class="item">
        <span class="field-value" style="width: 100%">
            <?= \yii\helpers\Html::a('Batafsil ko\'rish', ['/cp/forniture-service/view', 'id' => $model->id], ['class' => 'btn btn-primary','style'=>'width:100%']) ?>
        </span>
    </div>
</div>
