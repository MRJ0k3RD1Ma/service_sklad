<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Foydalanuvchilar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <div class="card">
        <div class="card-body">
            <p>
                <?= Html::a('Foydalanuvchi qo`shish', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

//                    'id',
//                    'name',
                    [
                        'attribute'=>'name',
                        'format'=>'raw',
                        'value'=>function($d){
                            $url = Yii::$app->urlManager->createUrl(['/cp/user/view','id'=>$d->id]);
                            return "<a href='{$url}'>{$d->name}</a>";
                        }
                    ],
                    'username',
                    'phone',
//                    'password',
//                    'auth_key',
                    //'token',
                    //'code',
                    //'access_token',
                    //'updated',
                    //'role_id',

                    //'image',
                    //'soato_id',

//                    'status',
                    [
                        'attribute'=>'status',
                        'value'=>function($d){
                            return Yii::$app->params['status'][$d->status];
                        },
                        'filter'=>Yii::$app->params['status']
                    ],
                    'created',
                ],
            ]); ?>
        </div>
    </div>




</div>
