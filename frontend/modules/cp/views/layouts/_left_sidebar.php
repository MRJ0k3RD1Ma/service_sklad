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
                <li>
                    <a href="<?= Yii::$app->urlManager->createUrl(['/cp/gen/sale'])?>" class="dropdown-toggle no-arrow <?= (Yii::$app->controller->id == 'gen' and Yii::$app->controller->action->id == 'sale') ? 'active' : ''?>">
                        <span class="micon bi bi-currency-dollar"></span>
                        <span class="mtext">Sotuv</span>
                    </a>
                </li>


                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon bi bi-list"></span>
                        <span class="mtext">Xizmatlar</span>
                    </a>
                    <ul class="submenu">
                        <li><a class="<?= Yii::$app->controller->id == 'goods' ? 'active' : ''?>" href="<?= Yii::$app->urlManager->createUrl(['/cp/goods'])?>">Mahsulotlar ro'yhati</a></li>
                        <li><a class="<?= Yii::$app->controller->id == 'goods-group' ? 'active' : ''?>" href="<?= Yii::$app->urlManager->createUrl(['/cp/goods-group'])?>">Mahsulot turlari</a></li>
                    </ul>
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


                <li>
                    <a href="<?= Yii::$app->urlManager->createUrl(['/cp/user'])?>" class="dropdown-toggle no-arrow <?= (Yii::$app->controller->id == 'user') ? 'active' : ''?>">
                        <span class="micon bi bi-people"></span>
                        <span class="mtext">Foydalanuvchilar</span>
                    </a>
                </li>


            </ul>
        </div>
    </div>
</div>


<div class="mobile-menu-overlay"></div>
