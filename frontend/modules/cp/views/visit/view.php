<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Visit $model */

$this->title = $model->car->number.'-'.$model->car->model;
$this->params['breadcrumbs'][] = ['label' => 'Visits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="visit-view">

    <div class="card">
        <div class="card-body">
            <p>
                <?php if($model->state == 'NEW'){?>
                    <a href="<?= Yii::$app->urlManager->createUrl(['/cp/visit/startservice','id'=>$model->id])?>" class="btn btn-primary">Xizmat ko'rsatishni boshlash</a>
                <?php }elseif($model->state == 'RUNNING'){?>
                <button class="btn btn-success md-btncreate" value="<?= Yii::$app->urlManager->createUrl(['/cp/visit/creategoods','id'=>$model->id])?>" type="button">Mahsulot qo`shish</button>
                <button class="btn btn-primary md-btncreate" value="<?= Yii::$app->urlManager->createUrl(['/cp/visit/createservice','id'=>$model->id])?>" type="button">Xizmat qo`shish</button>
                <button class="btn btn-danger md-btncreate" value="<?= Yii::$app->urlManager->createUrl(['/cp/visit/endservice','id'=>$model->id])?>" type="button">Xizmatni yakunlash</button>
                <?php }else{ ?>
                    <button class="btn btn-info " disabled>Xizmat ko'rsatish yakunlangan</button>
                    <button class="btn btn-info md-btncreate" value="<?= Yii::$app->urlManager->createUrl(['/cp/visit/paid','id'=>$model->id])?>"><span class="fa fa-money"></span> To'lovni qabul qilish</button>

                    <button class="btn btn-warning md-btncreate" value="<?= Yii::$app->urlManager->createUrl(['/cp/visit/credit','id'=>$model->id])?>"><span class="fa fa-credit-card"></span> Qarz yozish</button>


                    <button class='btn btn-primary printbtn' value='<?= Yii::$app->urlManager->createUrl(['/cp/visit/visitprint','id' => $model->id])?>'><span class='fa fa-print'></span> Qog'ozga chiqarish</button>

                    <?php
                     $this->registerJs("
                    $('.printbtn').click(function(){
                        let url = $(this).val();
                        window.open(url, '_blank', 'width=600,height=800,toolbar=0,location=0,menubar=0');
                        return false;
                    })
                ")
                                    ?>

                <?php }?>
            </p>
            <div class="row">
                <div class="col-md-3">

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
//                    'client_id',
                            [
                                'attribute'=>'user_id',
                                'value'=>function($model){
                                    return $model->user->name;
                                },
                            ],
                            [
                                'attribute'=>'client_id',
                                'value'=>function($model){
                                    $url = Yii::$app->urlManager->createUrl(['/cp/client/view','id'=>$model->client_id]);
                                    return Html::a($model->client->name.'<br>'.
                                        $model->client->phone.'<br>'.
                                        $model->client->balans.' so`m',$url);
                                },
                                'format'=>'raw',
                            ],
//                    'car_id',
                            'date',
                            'price',
                            'debt',
                            'credit',
//                    'register_id',
                            [
                                'attribute'=>'register_id',
                                'value'=>function($model){
                                    return $model->register->name;
                                },
                            ],
//                    'modify_id',
//                    'status',
                            [
                                'attribute'=>'status',
                                'value'=>function($model){
                                    return Yii::$app->params['status'][$model->status];
                                },
                            ],
                            'created',
                            'updated',
//                            'state',
                            [
                                'attribute'=>'state',
                                'value'=>function($d){
                                    return Yii::$app->params['service.state'][$d->state];
                                }
                            ],
                        ],
                    ]) ?>
                    <hr>
                    <img src="/upload/<?= $model->client->image ?>" alt="<?= $model->client->name ?>" style="width: 100%; height: auto; border-radius: 5px;">
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Mashina malumotlari-->
                            <h4>Ta`mirlanayotgan mashina ma`lumotlari</h4>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Raqami</th>
                                        <th>Modeli</th>
                                        <th>Пробег</th>
                                        <th>Izoh</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <?php $car = $model->car?>
                                    <td>1</td>
                                    <td><?= $car->number?></td>
                                    <td><?= $car->model?></td>
                                    <td><?= $car->run?> KM</td>
                                    <td><?= $car->ads?></td>
                                </tr>
                                </tbody>
                            </table>

                            <hr>
                            <h4>Qo`yilgan mahsulotlar va xizmatlar ro'yhati</h4>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nomi</th>
                                        <th>Narxi</th>
                                        <th>Soni</th>
                                        <th>Summasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i=1; foreach ($model->visitProducts as $visitProduct):?>
                                    <tr>
                                        <td><?= $i++?></td>
                                        <td><?= $visitProduct->product->name?></td>
                                        <td><?= $visitProduct->price?></td>
                                        <td><?php if($model->state == 'RUNNING'){?><input type="text" class="form-control item-product" value="<?= $visitProduct->cnt ?>" data-id="<?= $visitProduct->id?>"><?php }else{echo $visitProduct->cnt;}?></td>
                                        <td><?= $visitProduct->cnt_price?></td>
                                    </tr>
                                <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php $this->registerJs("
    $('.item-product').change(function(){
        var goods_id = $(this).data('id');
        var cnt = $(this).val();
        $.ajax({
            url:'".Yii::$app->urlManager->createUrl(['/cp/visit/updatecount'])."',
            type:'GET',
            data:{goods_id:goods_id,cnt:cnt,id:".$model->id."},
            success:function(data){
                if(data == 1){
                    window.location.reload();
                }
            }
        });
    })
");

?>