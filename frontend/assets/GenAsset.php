<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class GenAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/pos';
    public $css = [
        'css/tailwind.min.css',
        'css/style.css',
    ];
    public $js = [
        //'https://cdn.jsdelivr.net/npm/idb@8.0.0/build/umd.min.js',
        'js/umd.min.js',
        'js/alpine.min.js',
        'js/script.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
