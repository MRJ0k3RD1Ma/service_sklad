
<!-- header start -->
<header class="header">
    <div class="custom-container">
        <div class="head-content">
            <div class="header-location" onclick="window.location.href='<?= Yii::$app->urlManager->createUrl(['/service/default/index'])?>'" style="cursor: pointer">
                <img class="img-fluid profile-icon" src="/upload/<?= Yii::$app->user->identity->image?>"
                     alt="location">
                <div class="location-content">
                    <h5><?= Yii::$app->user->identity->name ?></h5>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="<?= Yii::$app->urlManager->createUrl(['/service/default/new'])?>">
                    <i class="iconsax icon-btn <?= \common\models\Visit::find()->where(['user_id'=>Yii::$app->user->id,'state'=>'NEW'])->count('*') > 0 ? 'notification-icon' : ''?>" data-icon="bell-2"></i>
                </a>
                <a href="<?= Yii::$app->urlManager->createUrl(['/site/logout'])?>" data-method="post">
                    <i class="iconsax icon-btn" data-icon="logout-2"></i>
                </a>
            </div>
        </div>
    </div>
</header>
<!-- header end -->