<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\Client $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Mijozlar ro`yhati', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="client-view">


    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <p>
                        <button class="btn btn-primary md-btnupdate" value="<?= Yii::$app->urlManager->createUrl(['/cp/client/update','id'=>$model->id])?>">O`zgartirish</button>
                        <?= Html::a('O`chirish', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                        <button class="btn btn-info md-btncreate" value="<?= Yii::$app->urlManager->createUrl(['/cp/client/paid','id'=>$model->id])?>"><span class="fa fa-money"></span> To'lovni qabul qilish</button>

                    </p>

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'name',
                            'phone',
                            'phone_two',
//                            'type_id',
                            [
                                'attribute'=>'type_id',
                                'value'=>function($d){
                                    return $d->type->name;
                                }
                            ],
                            'comment',
                            'balans',
                            'credit',
                            'debt',
//                            'status',
                            [
                                'attribute'=>'status',
                                'value'=>function($d){
                                    return Yii::$app->params['status'][$d->status];
                                }
                            ],
                            'created',
                            'updated',
                        ],
                    ]) ?>
                    <hr>
                    <img src="/upload/<?= $model->image ?>" alt="<?= $model->name ?>" style="width: 100%; height: auto; border-radius: 5px;">

                </div>



                <div class="col-md-9">

                    <div class="pd-20 card-box">
                        <h5 class="h4 text-blue mb-20">Mijoz bilan munosabatlar</h5>
                        <div class="tab">
                            <ul class="nav nav-tabs customtab" role="tablist">
                                <?php if(Yii::$app->params['access_service']){?>
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#cars" role="tab" aria-selected="true">Moshinalar</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#home2" role="tab" aria-selected="false">Tashriflar</a>
                                </li>


                                <?php }?>
                                <li class="nav-item">
                                    <a class="nav-link <?= !Yii::$app->params['access_service'] ? 'active' : ''?>" data-toggle="tab" href="#profile2" role="tab" aria-selected="<?= !Yii::$app->params['access_service'] ? 'true' : 'false'?>">To'lovlar</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#contact2" role="tab" aria-selected="false">Qaytarilgan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#contact3" role="tab" aria-selected="false">Qarzlar</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <?php if(Yii::$app->params['access_service']){?>
                                <div class="tab-pane fade active show" id="cars" role="tabpanel" style="padding-top:20px;">
                                    <p><button class="btn btn-primary md-btnupdate" value="<?= Yii::$app->urlManager->createUrl(['/cp/client/addcar','id'=>$model->id])?>">Moshina qo'shish</button></p>
                                    <?= GridView::widget([
                                        'dataProvider' => $carDataProvider,
                                        'filterModel' => $carSearchModel,
                                        'columns' => [
                                            ['class' => 'yii\grid\SerialColumn'],

//                                            'id',
//                                            'client_id',
//                                            'model',
                                            [
                                                'attribute'=>'model',
                                                'value'=>function($d){
                                                    $url = Yii::$app->urlManager->createUrl(['/cp/client-car/view','id'=>$d->id]);
                                                    return Html::a($d->model,$url);
                                                },
                                                'format'=>'raw'
                                            ],
                                            'number',
                                            'run',
                                            'call_date',
                                            'ads:ntext',
                                            [
                                                'attribute'=>'status',
                                                'value'=>function($d){
                                                    return Yii::$app->params['status'][$d->status];
                                                },
                                                'filter'=>Yii::$app->params['status']
                                            ],
                                            //'status',
                                            //'created',
                                            //'updated',
                                            'last_visit',
                                        ],
                                    ]); ?>


                                </div>


                                <div class="tab-pane fade show" id="home2" role="tabpanel" style="padding-top:20px;">

                                    <?= GridView::widget([
                                        'dataProvider' => $visitDataProvider,
                                        'filterModel' => $visitSearchModel,
                                        'columns' => [
                                            ['class' => 'yii\grid\SerialColumn'],

//                                            'id',
//                                            'client_id',
//                                            'car_id',
                                            [
                                                'attribute'=>'car_id',
                                                'value'=>function($d){
                                                    $url = Yii::$app->urlManager->createUrl(['/cp/client-car/view','id'=>$d->car_id]);
                                                    return Html::a($d->car->model.'<br>'.$d->car->number,$url);
                                                },
                                                'format'=>'raw'
                                            ],
//                                            'date',
                                            [
                                                'attribute'=>'date',
                                                'value'=>function($d){
                                                    $url = Yii::$app->urlManager->createUrl(['/cp/visit/view','id'=>$d->id]);
                                                    return Html::a($d->date,$url);
                                                },
                                                'format'=>'raw'
                                            ],
                                            'price',
                                            'debt',
                                            'credit',
                                            //'register_id',
                                            //'modify_id',
                                            //'status',
                                            //'created',
                                            //'updated',
                                            //'state',
                                            //'sale_id',
                                            //'user_id',
                                        ],
                                    ]); ?>

                                </div>
                                <?php }?>
                                <div class="tab-pane fade" id="profile2" role="tabpanel"  style="padding-top:20px;">




                                </div>
                                <div class="tab-pane fade" id="contact2" role="tabpanel"  style="padding-top:20px;">



                                </div>

                                <div class="tab-pane fade" id="contact3" role="tabpanel"  style="padding-top:20px;">



                                </div>
                            </div>
                        </div>
                    </div>




                </div>


            </div>
        </div>
    </div>

</div>
