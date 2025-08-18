<div class="left-side-bar">
    <div class="brand-logo">
        <a  href="<?= Yii::$app->urlManager->createUrl(['/cp/'])?>">
            <img src="/mbos.svg" alt="" style="height: 100%" class="dark-logo" />
            <img
                src="/mbos.svg"
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
                    <a href="<?= Yii::$app->urlManager->createUrl(['/user'])?>" class="dropdown-toggle no-arrow <?= Yii::$app->controller->id == 'user' ? 'active' : ''?>">
                        <span class="micon bi bi-person"></span>
                        <span class="mtext">Foydalanuvchilar</span>
                    </a>
                </li>



            </ul>
        </div>
    </div>
</div>


<div class="mobile-menu-overlay"></div>
