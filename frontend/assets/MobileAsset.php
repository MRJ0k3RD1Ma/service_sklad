<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class MobileAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/mobil';
    public $css = [
        'https://fonts.googleapis.com',
        'https://fonts.gstatic.com',
        'https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap',
        'css/swiper-bundle.min.css',
        'css/iconsax.css',
        'css/bootstrap.css',
        'css/style.css',
    ];
    public $js = [
        'js/swiper-bundle.min.js',
        'js/custom-swiper.js',
        'js/iconsax.js',
        'js/bootstrap.bundle.min.js',
        'js/template-setting.js',
        'js/script.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
