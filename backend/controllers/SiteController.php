<?php

namespace backend\controllers;

use backend\models\LoginForm;
use backend\models\User;
use Yii;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'corsFilter'=>[
                'class' => Cors::class,
            ],
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];

    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }
    public function getphone($phone){
        $phone_new = "";
        if(strlen($phone) < 9 ){
            return false;
        }
        for ($i=0; $i<strlen($phone);  $i++){
            if('0'<=$phone[$i] and $phone[$i] <= '9'){
                $phone_new.= $phone[$i];
            }
        }
        if(strlen($phone_new) > 9){
            if($phone_new[0]=='9' and $phone_new[1]=='9' and $phone_new[2]=='8'){
                $phone_new = substr($phone_new,3,strlen($phone_new));
            }else{
                return false;
            }
        }
//        (99)967-0395

        return '('.substr($phone_new,0,2).')'.substr($phone_new,2,3).'-'.substr($phone_new,5,4);
    }
    public function actionLogin(){

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post(),'')) {
            if($model->login()){

                $user = Yii::$app->user->identity;

                $token = Yii::$app->security->generateRandomString(64);

                $user->access_token = $token;
                $user->save(false);
                return [
                    'success'=>true,
                    'token' => (string) $token,
                    'user' => $user,
                ];
            }else{
                return [$model->getFirstErrors()];
            }
        } else {
            throw new HttpException(400, 'Bad request');
        }
    }

    public function actionLogout(){
        $user = Yii::$app->user->identity;
        $user->access_token = null;
        $user->save(false);
        Yii::$app->user->logout();
        return [
            'success'=>true,
            'message'=>'User logged out',
        ];
    }

}