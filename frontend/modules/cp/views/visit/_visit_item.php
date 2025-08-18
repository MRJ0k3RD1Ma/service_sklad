<?php
/* @var $model \common\models\Visit*/
?>

<div class="col-md-2 col-sm-4 numberBlock">
    <a href="<?= Yii::$app->urlManager->createUrl(['/cp/visit/view','id'=>$model->id])?>">
        <div class="numberBlockInner clearfix">
            <div class="numberImg">
                <p class="numberImgNum"><?= $model->car->number?></p>
                <br>
                <p style="font-size: 14px;"><?= $model->car->model ?></p>
            </div>

            <div class="numberInfoString">
                <p class="numberInfo left">
                    <span class="title">Summa</span>
                    <span class="element"><?= $model->price?> so'm</span>
                </p>
            </div>

            <div class="numberInfoString">
                <p class="numberInfo left">
                    <span class="title">Usta</span>
                    <span class="element"><?= $model->user->name ?></span>
                </p>
            </div>

            <div class="numberInfoString">
                <p class="status <?= $model->state?>">
                    <?= Yii::$app->params['service.state'][$model->state]?>
                </p>

            </div>
        </div>
    </a>

</div>