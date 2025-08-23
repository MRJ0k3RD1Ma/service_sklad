<?php

use kartik\mpdf\Pdf;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'cp' => [
            'class' => 'frontend\modules\cp\Module',
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module',
        ],


        'service' => [
            'class' => 'frontend\modules\service\Module',
        ],
    ],
    'language'=>'uz',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl'=>''
        ],
        'pdf' => [
            'class' => '\kartik\mpdf\Pdf',
            'format' => [100, 50], // 6x4 inch (mmda)
            'orientation' => 'P',
            //'destination' => Pdf::DEST_BROWSER,
            'marginLeft' => 2,
            'marginRight' => 2,
            'marginTop' => 3,
            'marginBottom' => 0,
            'marginHeader' => 0,
            'marginFooter' => 0,
            'options' => [
                'defaultfooterline' => 0,
            ],
        'methods' => [
            'SetTitle' => 'Barcode',
            'SetAuthor' => 'Dilmurod',
        ]
    ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],

    ],
    'params' => $params,
];

