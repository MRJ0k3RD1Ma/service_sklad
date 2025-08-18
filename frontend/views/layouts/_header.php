<div class="header">
    <div class="header-left">
        <div class="menu-icon bi bi-list"></div>
        <div class="search-toggle-icon bi bi-search" data-toggle="header_search"></div>
        <div class="header-search">
            <form>
                <div class="form-group mb-0">
                    <i class="dw dw-search2 search-icon"></i>
                    <input type="text" name="q" class="form-control search-input" style="font-size: 15px; height: 45px !important;" placeholder="Qidirish uchun kalit so'z kiriting"/>
                </div>
            </form>
        </div>
    </div>
    <div class="header-right">


        <div class="user-info-dropdown">
            <div class="dropdown">
                <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
							<span class="user-icon">
								<img src="/upload/<?= Yii::$app->user->identity->image ?>" alt=""/>
							</span>
                    <span class="user-name"><?= Yii::$app->user->identity->name ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                    <a class="dropdown-item" href="<?= Yii::$app->urlManager->createUrl(['/default/profil']) ?>"><i
                                class="dw dw-user1"></i> Profil</a>
                    <a class="dropdown-item" href="<?= Yii::$app->urlManager->createUrl(['/site/logout'])?>" data-method="post"><i class="dw dw-logout"></i> Chiqish</a>
                </div>
            </div>
        </div>

    </div>
</div>
