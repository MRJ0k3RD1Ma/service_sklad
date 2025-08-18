<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\FornitureService $model */

$this->title = $model->forniture->name;
$this->params['breadcrumbs'][] = ['label' => 'Buyurtmalar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="forniture-service-view">

    <div class="card">
        <div class="card-body">

            <p>
                <?= Html::a('O`zgartirish', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('O`chirish', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
                <?= Html::a('To`lov qilish', ['paid','id'=>$model->client_id], ['class' => 'btn btn-success']) ?>
                <?php if($model->state != 'COMPLETED'){?>
                    <a href="<?= Yii::$app->urlManager->createUrl(['/cp/forniture-service/cancel','id'=>$model->id])?>" class="btn btn-danger">Buyurtmani bekor qilish </a>
                    <a href="<?= Yii::$app->urlManager->createUrl(['/cp/forniture-service/changestate','id'=>$model->id])?>" class="btn btn-primary" data-confirm="Siz rostdan ham yangi bosqichga o'tmoqchimisiz?">
                        Holatni yangilash:
                        <?php $u=false; foreach (Yii::$app->params['forniture_service_state'] as $key=>$item):
                            if($u){echo $item; break;}
                            ?>
                            <?php if($key == $model->state){$u = true;}?>
                        <?php endforeach;?>
                    </a>
                <?php }?>

            </p>
            <div class="row">
                <div class="col-md-3">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
//                            'user_id',
//                            'client_id',
                        [
                            'attribute'=>'state',
                            'value'=>function($model){
                                return Yii::$app->params['forniture_service_state'][$model->state];
                            },
                        ],
                        [
                                'attribute'=>'saled_by_id',
                                'value'=>function($model){
                                    return $model->saledBy->name;
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
                            'address',
                            'phone',
//                            'wall_type_id',
                            [
                                'attribute'=>'wall_type_id',
                                'value'=>function($model){
                                    return $model->wallType->name;
                                },
                            ],
//                            'forniture_id',]
                            [
                                'attribute'=>'forniture_id',
                                'value'=>function($model){
                                    return $model->forniture->name;
                                },
                            ],
                            'price',
                            'debt',
                            'credit',
//                            'register_id',
//                            'modify_id',
                            'created',
                            'updated',
//                            'status',
                            [
                                'attribute'=>'status',
                                'value'=>function($model){
                                    return Yii::$app->params['status'][$model->status];
                                },
                            ],
//                            'saled_by_id',
//                            'referal_id',
                            'ads:ntext',
                        ],
                    ]) ?>
                </div>


                <div class="col-md-9">

                    <h4>Ustalar ro'yhati
                        <span style="float: right">
                            <button class="btn btn-success md-btncreate" value="<?= Yii::$app->urlManager->createUrl(['/cp/forniture-service/addworker','id'=>$model->id])?>"> Usta qo'shish </button>
                        </span>
                    </h4>
                    <hr>

                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Usta</th>
                            <th>Summasi:</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $n=0; foreach ($model->workers as $worker): $n++;?>
                            <tr>
                                <td><?= $n?></td>
                                <td><?= $worker->user->name?></td>
                                <td><?= number_format($model->price_agreed * Yii::$app->params['worker'] / 100 / $model->cntWorker, 0, ' ',' ')?> so'm</td>
                                <td><a href="<?= Yii::$app->urlManager->createUrl(['/cp/forniture-service/deleteworker','id'=>$worker->id])?>" class="btn btn-danger" data-confirm="Siz rostdan ham ushbu ustani bu buyurtmani tayyorlashdan olib tashlamoqchimisiz?">O'chirish</a></td>
                            </tr>
                        <?php endforeach;?>
                        <tr>
                            <td colspan="2" style="text-align: right">
                                <b>Jami:</b>
                            </td>
                            <td>
                                <b><?= number_format($model->price_agreed * Yii::$app->params['worker'] / 100, 0, ' ',' ')?> so'm</b>
                            </td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>


                </div>


            </div>


            <div class="row">
                <div class="col-md-12">
                    <h4>Ushbu buyurtmani tayyorlash uchun ketgan mahsulotlar
                        <span style="float: right">
                            <button class="btn btn-success md-btncreate" value="<?= Yii::$app->urlManager->createUrl(['/cp/forniture-service/creategoods','id'=>$model->id])?>" type="button">Mahsulot qo`shish</button>
                            <button class="btn btn-primary md-btncreate" value="<?= Yii::$app->urlManager->createUrl(['/cp/forniture-service/createservice','id'=>$model->id])?>" type="button">Xizmat qo`shish</button>
                        </span>
                    </h4>
                    <hr>

                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Mahsulot</th>
                            <th>Narxi</th>
                            <th>Soni</th>
                            <th>Jami</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=1; foreach ($model->fornitureProducts as $fornitureProducts):?>
                            <tr>
                                <td><?= $i++?></td>
                                <td><?= $fornitureProducts->product->name?></td>
                                <td><?= $fornitureProducts->price?></td>
                                <td><?php if($model->state != 'COMPLETED' or $model->state != 'CANCELED'){?><input type="text" class="form-control item-product" value="<?= $fornitureProducts->cnt ?>" data-id="<?= $fornitureProducts->id?>"><?php }else{echo $fornitureProducts->cnt;}?></td>
                                <td><?= $fornitureProducts->cnt_price?></td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>


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
            url:'".Yii::$app->urlManager->createUrl(['/cp/forniture-service/updatecount'])."',
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