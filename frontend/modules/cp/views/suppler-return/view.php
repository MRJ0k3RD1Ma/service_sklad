<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\SupplerReturn $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Suppler Returns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="suppler-return-view">

    <div class="card">
        <div class="card-body">


            <div class="row">
                <div class="col-md-3">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'date',
                            'code',
//                            'code_id',
//                            'nakladnoy',
//                            'suppler_id',
                            [
                                'attribute' => 'suppler_id',
                                'value'=>function($d){
                                    $url = \yii\helpers\Url::toRoute(['/cp/suppler/view','id'=>$d->suppler_id]);
                                    return Html::a($d->suppler->name,$url);
                                },
                                'format'=>'raw',
                                'filter'=>\yii\helpers\ArrayHelper::map(\common\models\Suppler::find()->where(['status'=>1])->all(),'id','name')
                            ],
                            'price',
                            'comment:ntext',
                            'register_id',
                            'status',
                            'created',
                            'updated',
                        ],
                    ]) ?>
                </div>

                <div class="col-md-9">
                    <h3>Qaytarilgan mahsulotlar</h3>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Mahsulot</th>
                            <th>Soni</th>
                            <th>Narxi</th>
                            <th>Summasi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $total = 0;
                        foreach ($model->supplerReturnProducts as $key=>$item){
                            $total += $item->cnt_price;
                            ?>
                            <tr>
                                <td><?= $key+1?></td>
                                <td><?= $item->goods->name?></td>
                                <td><?= $item->cnt?></td>
                                <td><?= $item->price?> so'm</td>
                                <td><?= $item->cnt_price?> so'm</td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="4" class="text-right">Jami:</td>
                            <td><?= $total?> so'm</td>
                        </tr>
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>

</div>
