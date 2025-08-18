<div class="left-side-bar">
    <div class="brand-logo">
        <a  href="<?= Yii::$app->urlManager->createUrl(['/cp/'])?>">
            <img src="/logo.svg" alt="" style="height: 100%" class="dark-logo" />
            <img
                src="/logo.svg"
                alt=""
                class="light-logo"
            />
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <li>
                    <a href="<?= Yii::$app->urlManager->createUrl(['/'])?>" class="dropdown-toggle no-arrow <?= Yii::$app->controller->id == 'site' ? 'active' : ''?>">
						<span class="micon bi bi-house"></span>
                        <span class="mtext">Dashboard</span>
                    </a>
                </li>


                <li>
                    <a href="<?= Yii::$app->urlManager->createUrl(['/cp/transaction'])?>" class="dropdown-toggle no-arrow <?= Yii::$app->controller->id == 'transaction' ? 'active' : ''?>">
                        <span class="micon fa fa-bank"></span>
                        <span class="mtext">Depozitlar</span>
                    </a>
                </li>


                <li>
                    <a href="<?= Yii::$app->urlManager->createUrl(['/cp/payout'])?>" class="dropdown-toggle no-arrow <?= Yii::$app->controller->id == 'payout' ? 'active' : ''?>">
                        <span class="micon fa fa-dollar"></span>
                        <span class="mtext">Pul chiqarishlar</span>
                    </a>
                </li>



                <li>
                    <a href="<?= Yii::$app->urlManager->createUrl(['/cp/wallet'])?>" class="dropdown-toggle no-arrow <?= Yii::$app->controller->id == 'wallet' ? 'active' : ''?>">
                        <span class="micon fa fa-id-card"></span>
                        <span class="mtext">Walletlar</span>
                    </a>
                </li>

                <li>
                    <a href="<?= Yii::$app->urlManager->createUrl(['/cp/card'])?>" class="dropdown-toggle no-arrow <?= Yii::$app->controller->id == 'card' ? 'active' : ''?>">
                        <span class="micon fa fa-credit-card"></span>
                        <span class="mtext">Kartalar</span>
                    </a>
                </li>


                <li>
                    <a href="<?= Yii::$app->urlManager->createUrl(['/cp/client'])?>" class="dropdown-toggle no-arrow <?= Yii::$app->controller->id == 'client' ? 'active' : ''?>">
                        <span class="micon fa fa-users"></span>
                        <span class="mtext">Mijozlar</span>
                    </a>
                </li>




                <li>
                    <a href="<?= Yii::$app->urlManager->createUrl(['/cp/user'])?>" class="dropdown-toggle no-arrow <?= Yii::$app->controller->id == 'user' ? 'active' : ''?>">
                        <span class="micon bi bi-person"></span>
                        <span class="mtext">Administratorlar</span>
                    </a>
                </li>



            </ul>
        </div>
    </div>
</div>


<div class="mobile-menu-overlay"></div>
