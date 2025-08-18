<?php

namespace frontend\modules\cp\controllers;

use common\models\Client;
use common\models\ClientCar;
use common\models\Paid;
use common\models\PaidClient;
use common\models\Sale;
use common\models\search\ClientCarSearch;
use common\models\search\ClientSearch;
use common\models\search\VisitSearch;
use frontend\components\Common;
use Imagine\Image\ManipulatorInterface;
use yii\imagine\Image;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\web\UploadedFile;

/**
 * ClientController implements the CRUD actions for Client model.
 */
class ClientController extends Controller
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
     * Lists all client model.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ClientSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [

           'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPaid($id)
    {
        $model = new Paid();
        $model->register_id = Yii::$app->user->id;
        $model->modify_id = Yii::$app->user->id;
        $client = $this->findModel($id);
        if($model->load($this->request->post())){
            // create paid yaratish va client_paid yaratish va
            // clientning balansidan kamaytirish sotilgan mahsulotdan kamaytirish
            if($model->save()){

             
                $client->balans += $model->price;
                $client->credit -= $model->price;
                $client->debt += $model->price;
                $client->save(false);

                $client_paid = new PaidClient();
                $client_paid->client_id = $client->id;
                $client_paid->paid_id = $model->id;
                $client_paid->save(false);

                if($client->balans > 0){
                    Common::ClientPaid($client->id);
                }

                \Yii::$app->session->setFlash('success','Muvoffaqiyatli saqlandi');
                return $this->redirect(['view','id'=>$id]);
            }
        }

        return $this->renderAjax('_paid',['model'=>$model]);

    }


    public function actionDebt()
    {
        $searchModel = new ClientSearch();
        $searchModel->search_type = 'DEBT';
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCredit()
    {
        $searchModel = new ClientSearch();
        $searchModel->search_type = 'CREDIT';
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAddcar($id)
    {
        $model = new ClientCar();
        $model->client_id = $id;
        if($model->load($this->request->post())){
            $model->call_date = date('Y-m-d',strtotime($model->call_date));
            if($model->save()){
                Yii::$app->session->setFlash('success','Amal muvaffaqiyatli bajarildi');
            }else{
                Yii::$app->session->setFlash('error','Ma`lumotni saqlashda xatolik');
            }
            return $this->redirect(['view','id'=>$id]);
        }
        return $this->renderAjax('_addcar',[
            'model'=>$model
        ]);
    }

    public function actionUpdatecar($id)
    {
        $model = ClientCar::findOne($id);
        if($model->load($this->request->post())){
            $model->call_date = date('Y-m-d',strtotime($model->call_date));
            if($model->save()){
                Yii::$app->session->setFlash('success','Amal muvaffaqiyatli bajarildi');
            }else{
                Yii::$app->session->setFlash('error','Ma`lumotni saqlashda xatolik');
            }
            return $this->redirect(['view','id'=>$model->client_id]);
        }
        return $this->renderAjax('_addcar',[
            'model'=>$model
        ]);
    }

    /**
     * Displays a single Client model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $carSearchModel = new ClientCarSearch();
        $carSearchModel->client_id = $id;
        $carDataProvider = $carSearchModel->search($this->request->queryParams);

        $visitSearchModel = new VisitSearch();
        $visitSearchModel->client_id = $id;
        $visitDataProvider = $visitSearchModel->search($this->request->queryParams);


        return $this->render('view', [
            'model' => $this->findModel($id),
            'carSearchModel' => $carSearchModel,
            'carDataProvider' => $carDataProvider,
            'visitSearchModel' => $visitSearchModel,
            'visitDataProvider' => $visitDataProvider,
        ]);
    }

    /**
     * Creates a new Client model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Client();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) ) {
                if($model->image = UploadedFile::getInstance($model,'image')){
                    $name = 'client/'.microtime(true).'.'.$model->image->extension;
                    if(!is_dir(Yii::$app->basePath.'/web/upload/client/')){
                        mkdir(Yii::$app->basePath.'/web/upload/client/',0777,true);
                    }
                    $model->image->saveAs(Yii::$app->basePath.'/web/upload/'.$name);
                    $model->image = $name;

                    Image::resize(Yii::$app->basePath.'/web/upload/'.$name, 1024,null,ManipulatorInterface::THUMBNAIL_INSET)
                        ->save(Yii::$app->basePath.'/web/upload/'.$name, ['quality' => 70]);

                }else{
                    $model->image = 'default/avatar.png';
                }
                if($model->save()){
                    Yii::$app->session->setFlash('success','Amal muvaffaqiyatli bajarildi');
                    return $this->redirect(['view', 'id' => $model->id]);
                }else{
                    Yii::$app->session->setFlash('error','Ma`lumotni saqlashda xatolik. Iltimos qayta urinib ko`ring.');
                    return $this->redirect(['index']);
                }

            }else{
                Yii::$app->session->setFlash('error','Ma`lumotni qo`shishda xatolik. Iltimos qayta urinib ko`ring.');
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Client model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $img = $model->image;
        if ($this->request->isPost && $model->load($this->request->post())) {
            if($model->image = UploadedFile::getInstance($model,'image')){
                $name = 'client/'.microtime(true).'.'.$model->image->extension;
                if(!is_dir(Yii::$app->basePath.'/web/upload/client/')){
                    mkdir(Yii::$app->basePath.'/web/upload/client/',0777,true);
                }
                $model->image->saveAs(Yii::$app->basePath.'/web/upload/'.$name);
                $model->image = $name;

                Image::resize(Yii::$app->basePath.'/web/upload/'.$name, 1024,null,ManipulatorInterface::THUMBNAIL_INSET)
                    ->save(Yii::$app->basePath.'/web/upload/'.$name, ['quality' => 70]);

            }else{
                $model->image = $img;
            }


            if($model->save()){
                Yii::$app->session->setFlash('success','Amal muvaffaqiyatli bajarildi');
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Ma`lumotni o`zgartirishda xatolik. Iltimos qayta urinib ko`ring.');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Client model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = -1;
        if($model->save()){
            Yii::$app->session->setFlash('success','Amal muvaffaqiyatli bajarildi');
        }else{
            Yii::$app->session->setFlash('error','Ma`lumotni o`chirishda xatolik');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Client model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Client the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Client::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
