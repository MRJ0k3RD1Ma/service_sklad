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
                    <a href="<?= Yii::$app->urlManager->createUrl(['/cp/'])?>" class="dropdown-toggle no-arrow <?= Yii::$app->controller->id == 'default' ? 'active' : ''?>">
                        <span class="micon bi bi-house"></span>
                        <span class="mtext">Dashboard</span>
                    </a>
                </li>

                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon bi bi-gear-fill"></span>
                        <span class="mtext">Kassa</span>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="<?= Yii::$app->urlManager->createUrl(['/cp/paid'])?>" class="dropdown-toggle no-arrow <?= (Yii::$app->controller->id == 'paid') ? 'active' : ''?>">
                                <span class="mtext">Tushumlar</span>
                            </a>
                        </li>
                        <li><a class="<?= (Yii::$app->controller->id == 'paid-worker') ? 'active' : ''?>" href="<?= Yii::$app->urlManager->createUrl(['/cp/paid-worker'])?>">Xodimlarga to'lovlar</a></li>
                        <li><a class="<?= (Yii::$app->controller->id == 'paid-other') ? 'active' : ''?>" href="<?= Yii::$app->urlManager->createUrl(['/cp/paid-other'])?>">Boshqa to'lovlar</a></li>
                        <li><a class="<?= (Yii::$app->controller->id == 'paid-other-group') ? 'active' : ''?>" href="<?= Yii::$app->urlManager->createUrl(['/cp/paid-other-group'])?>">Boshqa to'lov turlari</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon bi bi-list"></span>
                        <span class="mtext">Xizmatlar</span>
                    </a>
                    <ul class="submenu">
                        <li><a class="<?= Yii::$app->controller->id == 'product' ? 'active' : ''?>" href="<?= Yii::$app->urlManager->createUrl(['/cp/product'])?>">Xizmatlar ro'yhati</a></li>
                        <li><a class="<?= Yii::$app->controller->id == 'product-group' ? 'active' : ''?>" href="<?= Yii::$app->urlManager->createUrl(['/cp/product-group'])?>">Xizmatlar turlari</a></li>
                        <li><a class="<?= Yii::$app->controller->id == 'product-unit' ? 'active' : ''?>" href="<?= Yii::$app->urlManager->createUrl(['/cp/product-unit'])?>">Xizmatlar birliklari</a></li>
                    </ul>
                </li>

                <li>
                    <a href="<?= Yii::$app->urlManager->createUrl(['/cp/worker'])?>" class="dropdown-toggle no-arrow <?= Yii::$app->controller->id == 'worker' ? 'active' : ''?>">
                        <span class="micon bi bi-person-badge"></span>
                        <span class="mtext">Brigadirlar</span>
                    </a>
                </li>

                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon bi bi-people"></span>
                        <span class="mtext">Mijozlar</span>
                    </a>
                    <ul class="submenu">
                        <li><a class="<?= (Yii::$app->controller->id == 'client'
                                and Yii::$app->controller->action->id != 'credit'
                                and Yii::$app->controller->action->id != 'debt'
                            ) ? 'active' : ''?>" href="<?= Yii::$app->urlManager->createUrl(['/cp/client'])?>">Mijozlar ro'yhati</a></li>
                        <li><a class="<?= (Yii::$app->controller->id == 'client'
                                and Yii::$app->controller->action->id == 'credit'
                            ) ? 'active' : ''?>" href="<?= Yii::$app->urlManager->createUrl(['/cp/client/credit'])?>">Qarzdorlar</a></li>
                        <li><a class="<?= (Yii::$app->controller->id == 'client'
                                and Yii::$app->controller->action->id == 'debt'
                            ) ? 'active' : ''?>" href="<?= Yii::$app->urlManager->createUrl(['/cp/client/debt'])?>">Ortiqcha to'laganlar</a></li>

                        <li><a class="<?= Yii::$app->controller->id == 'client-type' ? 'active' : ''?>" href="<?= Yii::$app->urlManager->createUrl(['/cp/client-type'])?>">Mijoz turlari</a></li>
                    </ul>
                </li>



                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon bi bi-gear-fill"></span>
                        <span class="mtext">Sozlamalar</span>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="<?= Yii::$app->urlManager->createUrl(['/cp/user'])?>" class="dropdown-toggle no-arrow <?= (Yii::$app->controller->id == 'user') ? 'active' : ''?>">
                                <span class="mtext">Foydalanuvchilar</span>
                            </a>
                        </li>
                        <li><a class="<?= (Yii::$app->controller->id == 'payment') ? 'active' : ''?>" href="<?= Yii::$app->urlManager->createUrl(['/cp/payment'])?>">To'lov turlari</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</div>


<div class="mobile-menu-overlay"></div>
