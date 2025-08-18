<li>
    <a href="<?= Yii::$app->urlManager->createUrl(['/cp/'])?>" class="dropdown-toggle no-arrow <?= Yii::$app->controller->id == 'default' ? 'active' : ''?>">
        <span class="micon bi bi-house"></span>
        <span class="mtext">Dashboard</span>
    </a>
</li>


<li>
    <a href="<?= Yii::$app->urlManager->createUrl(['/cp/forniture-service'])?>" class="dropdown-toggle no-arrow <?= Yii::$app->controller->id == 'forniture-service' ? 'active' : ''?>">
        <span class="micon bi bi-clipboard-check"></span>
        <span class="mtext">Buyurtmalar</span>
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
        <span class="micon bi bi-cash-stack"></span>
        <span class="mtext">Sotuvlar</span>
    </a>
    <ul class="submenu">
        <li><a class="<?= (Yii::$app->controller->id == 'sale' and Yii::$app->controller->action->id == 'index') ? 'active' : ''?>" href="<?= Yii::$app->urlManager->createUrl(['/cp/sale'])?>">Sotilgan mahsulotlar</a></li>
        <li><a class="<?= (Yii::$app->controller->id == 'sale' and Yii::$app->controller->action->id == 'credit') ? 'active' : ''?>" href="<?= Yii::$app->urlManager->createUrl(['/cp/sale/credit'])?>">Qarzga berilgan</a></li>
        <li><a class="" href="#">Qaytarish</a></li>
    </ul>
</li>
<li class="dropdown">
    <a href="javascript:;" class="dropdown-toggle">
        <span class="micon bi bi-currency-exchange"></span>
        <span class="mtext">Kassa</span>
    </a>
    <ul class="submenu">
        <li><a class="<?= (Yii::$app->controller->id == 'paid' ) ? 'active' : ''?>" href="<?= Yii::$app->urlManager->createUrl(['/cp/paid'])?>">Tushumlar</a></li>
        <li><a class="<?= (Yii::$app->controller->id == 'suppler-paid' ) ? 'active' : ''?>" href="<?= Yii::$app->urlManager->createUrl(['/cp/suppler-paid'])?>">Yetkazuvchilarga to'langan</a></li>
        <li><a class="<?= (Yii::$app->controller->id == 'paid-other' ) ? 'active' : ''?>" href="<?= Yii::$app->urlManager->createUrl(['/cp/paid-other'])?>">Boshqa to'lovlar</a></li>
    </ul>
</li>
<li class="dropdown">
    <a href="javascript:;" class="dropdown-toggle">
        <span class="micon bi bi-archive"></span>
        <span class="mtext">Sklad</span>
    </a>
    <ul class="submenu">
        <li><a class="<?= (Yii::$app->controller->id == 'gen' and Yii::$app->controller->action->id == 'income') ? 'active' : ''?>" href="<?= Yii::$app->urlManager->createUrl(['/cp/gen/income'])?>">Mahsulot qabul qilish</a></li>
        <li><a class="<?= (Yii::$app->controller->id == 'come' and Yii::$app->controller->action->id == 'reminder') ? 'active' : ''?>" href="<?= Yii::$app->urlManager->createUrl(['/cp/come/reminder'])?>">Qoldiqlar</a></li>
        <li><a class="<?= (Yii::$app->controller->id == 'gen' and Yii::$app->controller->action->id == 'returntosuppler') ? 'active' : ''?>" href="<?= Yii::$app->urlManager->createUrl(['/cp/gen/returntosuppler'])?>">Qaytarish</a></li>
    </ul>
</li>
<li class="dropdown">
    <a href="javascript:;" class="dropdown-toggle">
        <span class="micon bi bi-list"></span>
        <span class="mtext">Mahsulotlar</span>
    </a>
    <ul class="submenu">
        <li><a class="<?= Yii::$app->controller->id == 'goods' ? 'active' : ''?>" href="<?= Yii::$app->urlManager->createUrl(['/cp/goods'])?>">Mahsulotlar ro'yhati</a></li>
        <li><a class="<?= Yii::$app->controller->id == 'goods-group' ? 'active' : ''?>" href="<?= Yii::$app->urlManager->createUrl(['/cp/goods-group'])?>">Mahsulot turlari</a></li>
    </ul>
</li>

<li class="dropdown">
    <a href="javascript:;" class="dropdown-toggle">
        <span class="micon bi bi-list-check"></span>
        <span class="mtext">Xizmatlar</span>
    </a>
    <ul class="submenu">
        <li><a class="<?= Yii::$app->controller->id == 'service' ? 'active' : ''?>" href="<?= Yii::$app->urlManager->createUrl(['/cp/service'])?>">Xizmatlar ro'yhati</a></li>
        <li><a class="<?= Yii::$app->controller->id == 'service-group' ? 'active' : ''?>" href="<?= Yii::$app->urlManager->createUrl(['/cp/service-group'])?>">Xizmat turlari</a></li>
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


<li class="dropdown">
    <a href="javascript:;" class="dropdown-toggle">
        <span class="micon bi bi-truck"></span>
        <span class="mtext">Yetkavchilar</span>
    </a>
    <ul class="submenu">
        <li><a class="<?= (Yii::$app->controller->id == 'suppler' and (Yii::$app->controller->action->id == 'index' or Yii::$app->controller->action->id == 'view')) ? 'active' : ''?>" href="<?= Yii::$app->urlManager->createUrl(['/cp/suppler'])?>">Yetkazuvchilar Ro'yhat</a></li>
        <li><a class="<?= (Yii::$app->controller->id == 'suppler' and Yii::$app->controller->action->id == 'income') ? 'active' : ''?>" href="<?= Yii::$app->urlManager->createUrl(['/cp/suppler/income'])?>">Kelgan mahsulotlar</a></li>
        <li><a class="<?= (Yii::$app->controller->id == 'suppler-return') ? 'active' : ''?>" href="<?= Yii::$app->urlManager->createUrl(['/cp/suppler-return'])?>">Qaytarilgan mahsulotlar</a></li>
        <li><a class="<?= (Yii::$app->controller->id == 'suppler' and Yii::$app->controller->action->id == 'debt') ? 'active' : ''?>" href="<?= Yii::$app->urlManager->createUrl(['/cp/suppler/debt'])?>">Qarzlarim</a></li>
        <li><a class="<?= (Yii::$app->controller->id == 'suppler' and Yii::$app->controller->action->id == 'credit') ? 'active' : ''?>" href="<?= Yii::$app->urlManager->createUrl(['/cp/suppler/credit'])?>">Ortiqcha to`lovlar</a></li>
    </ul>
</li>


<li class="dropdown">
    <a href="javascript:;" class="dropdown-toggle">
        <span class="micon bi bi-gear-fill"></span>
        <span class="mtext">Sozlamalar</span>
    </a>
    <ul class="submenu">
        <li><a class="<?= (Yii::$app->controller->id == 'user') ? 'active' : ''?>" href="<?= Yii::$app->urlManager->createUrl(['/cp/user'])?>">Foydalanuvchilar</a></li>
        <li><a href="<?= Yii::$app->urlManager->createUrl(['/cp/forniture'])?>" class="<?= Yii::$app->controller->id == 'forniture' ? 'active': ''?>">Buyurtma turlari</a></li>
        <li><a href="<?= Yii::$app->urlManager->createUrl(['/cp/forniture-wall-type'])?>" class="<?= Yii::$app->controller->id == 'forniture-wall-type' ? 'active': ''?>">Devor turlari</a></li>
        <li><a class="<?= (Yii::$app->controller->id == 'default' and Yii::$app->controller->action->id == 'setting') ? 'active' : ''?>" href="<?= Yii::$app->urlManager->createUrl(['/cp/default/setting'])?>">Chek ma'lumotlari</a></li>
        <li><a class="<?= (Yii::$app->controller->id == 'custom-type') ? 'active' : ''?>" href="<?= Yii::$app->urlManager->createUrl(['/cp/custom-type'])?>">Boshqa sozlamalar</a></li>
    </ul>
</li>