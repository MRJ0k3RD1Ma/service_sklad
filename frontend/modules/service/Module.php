<?php

namespace frontend\modules\service;

use yii\filters\AccessControl;
use Yii;
/**
 * service module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\service\controllers';
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if(Yii::$app->user->identity->role_id == 60){
                                return true;
                            }
                            header('Location: '.Yii::$app->user->identity->role->url);
                            exit;
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        Yii::$app->viewPath = '@frontend/modules/service/views/';
        // custom initialization code goes here
    }
}
