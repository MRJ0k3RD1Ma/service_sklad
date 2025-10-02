<?php

namespace backend\controllers;

use Yii;
use yii\filters\Cors;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use common\models\User;

/**
 * User REST API Controller
 */
class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';

    /**
     * Behaviors configuration
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        // CORS - eng birinchi bo'lishi kerak!
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['http://localhost:5173', 'http://127.0.0.1:5173'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
            ],
        ];
        // Content negotiation - JSON formatda javob qaytaradi
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        // Bearer Token autentifikatsiya
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'except' => ['options'],
        ];

        return $behaviors;
    }

    public function actionOptions()
    {
        if (Yii::$app->request->method === 'OPTIONS') {
            Yii::$app->response->statusCode = 200;
            return null;
        }
    }
    /**
     * Actions configuration
     */
    public function actions()
    {
        $actions = parent::actions();

        // Faqat index action kerak bo'lsa, boshqa actionlarni o'chirish
        unset($actions['create'], $actions['update'], $actions['delete'], $actions['view']);

        // Index action uchun custom configuration
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    /**
     * Data provider tayyorlash
     */
    public function prepareDataProvider()
    {
        $searchModel = new \yii\data\ActiveDataProvider([
            'query' => User::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        return $searchModel;
    }

    /**
     * Custom index action (ixtiyoriy)
     * Agar o'zingizning custom logikangiz kerak bo'lsa
     */
    /*
    public function actionIndex()
    {
        $users = User::find()
            ->select(['id', 'username', 'email', 'created_at'])
            ->all();

        return [
            'success' => true,
            'data' => $users,
            'count' => count($users),
        ];
    }
    */
}