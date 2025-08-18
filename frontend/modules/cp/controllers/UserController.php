<?php

namespace frontend\modules\cp\controllers;

use common\models\User;
use common\models\search\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\web\UploadedFile;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new User();
        $model->scenario = "insert";
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                if($model->image = UploadedFile::getInstance($model,'image')){
                    $name = 'avatar/'.microtime(true).".".$model->image->extension;
                    if(!file_exists(Yii::$app->basePath.'/web/upload/avatar')){
                        mkdir(Yii::$app->basePath.'/web/upload/avatar');
                    }
                    $model->image->saveAs(Yii::$app->basePath.'/web/upload/'.$name);
                    $model->image = $name;
                }else{
                    $model->image = "default/avatar.png";
                }
                echo $model->password;

                $model->setPassword($model->password);

                if($model->save()){
                    Yii::$app->session->setFlash('success','Ma`lumotlar muvoffaqiyatli saqlandi');
                    return $this->redirect(['view', 'id' => $model->id]);
                }else{

                    Yii::$app->session->setFlash('error','Ma`lumotlarni saqlashda xatolik. Kiritilgan ma`lumotlarni to`g`ri va to`liqligini qayta tekshirib ko`ring.');
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $img = $model->image;
        $pas = $model->password;
        if ($this->request->isPost && $model->load($this->request->post())) {

            if($model->image = UploadedFile::getInstance($model,'image')){
                $name = 'avatar/'.microtime(true).".".$model->image->extension;
                if(!file_exists(Yii::$app->basePath.'/web/upload/avatar')){
                    mkdir(Yii::$app->basePath.'/web/upload/avatar');
                }
                $model->image->saveAs(Yii::$app->basePath.'/web/upload/'.$name);
                $model->image = $name;

                if(!file_exists(Yii::$app->basePath.'/web/upload/'.$img) and $img != "default/avatar.png"){
                    unlink(Yii::$app->basePath.'/web/upload/'.$img);
                }
            }else{
                $model->image = $img;
            }
            if($model->password){
                $model->password = $model->setPassword($model->password);
            }else{
                $model->password = $pas;
            }
            if($model->save()){
                Yii::$app->session->setFlash('success','Ma`lumotlar muvoffaqiyatli saqlandi');
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                Yii::$app->session->setFlash('error','Ma`lumotlarni saqlashda xatolik. Kiritilgan ma`lumotlarni to`g`ri va to`liqligini qayta tekshirib ko`ring.');
            }
        }
        $model->password = "";
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = -1;
        $model->save(false);
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

