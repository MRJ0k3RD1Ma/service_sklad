<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Foydalanuvchilar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

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
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'name',
                    'username',
//                    'password',
//                    'auth_key',
//                    'token',
//                    'code',
//                    'access_token',
                    'created',
                    'updated',
                    [
                        'attribute'=>'status',
                        'value'=>function($d){
                            return Yii::$app->params['status'][$d->status];
                        }
                    ],
//                    'status',
//                    'role_id',
//                    'image',
                    [
                        'attribute'=>'image',
                        'value'=>function($d){
                            return "<img src='/upload/{$d->image}' style='height: 200px;'>";
                        },
                        'format'=>'raw'
                    ],
//                    'soato_id',

                    'phone',
                ],
            ]) ?>
        </div>
    </div>

</div>
