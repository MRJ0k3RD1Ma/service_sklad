

<!-- bottom navbar start -->
<div class="navbar-menu" id="navbarmenuid" style="display: <?php if(Yii::$app->controller->action->id != 'view' ){ echo "block"; }else{echo "none";}?>">
    <ul>
        <li class="<?= (Yii::$app->controller->id == 'default' and Yii::$app->controller->action->id == 'index')  ? 'active' : '' ?>">
            <a href="<?= Yii::$app->urlManager->createUrl(['/service/'])?>">
                <div class="icon">
                    <img class="unactive" src="/mobil/img/home.svg" alt="home">
                    <img class="active" src="/mobil/img/home-fill.svg" alt="home">
                </div>
                <h5>Home</h5>
            </a>
        </li>

        <li class="<?= Yii::$app->controller->id == 'running' ? 'active' : '' ?>">
            <a href="<?= Yii::$app->urlManager->createUrl(['/service/default/running'])?>">
                <div class="icon">
                    <img class="unactive" src="/mobil/img/booking.svg" alt="booking">
                    <img class="active" src="/mobil/img/booking-fill.svg" alt="booking">
                </div>
                <h5>Jarayonda</h5>
            </a>
        </li>

        <?php if(false){?>
        <li>
            <a href="#add-modal" class="scanner-btn" data-bs-toggle="modal">
                <i class="iconsax icon-btn" data-icon="add"></i>
            </a>
        </li>
        <?php }?>

        <li class="<?= Yii::$app->controller->id == 'completed' ? 'active' : '' ?>">
            <a href="<?= Yii::$app->urlManager->createUrl(['/service/default/completed'])?>">
                <div class="icon">
                    <img class="unactive" src="/mobil/img/wallet-open.svg" alt="wallet">
                    <img class="active" src="/mobil/img/wallet-fill.svg" alt="wallet">
                </div>
                <h5 class="<?= Yii::$app->controller->id == 'completed' ? 'active' : '' ?>">Tugallangan</h5>
            </a>
        </li>

        <li class="<?= (Yii::$app->controller->id == 'default' and Yii::$app->controller->action->id == 'profile') ? 'active' : ''?>">
            <a href="<?= Yii::$app->urlManager->createUrl(['/service/default/profile'])?>">
                <div class="icon">
                    <img class="unactive" src="/mobil/img/profile.svg" alt="profile">
                    <img class="active" src="/mobil/img/profile-fill.svg" alt="profile">
                </div>
                <h5>Profil</h5>
            </a>
        </li>
    </ul>
</div>
<!-- bottom navbar end -->