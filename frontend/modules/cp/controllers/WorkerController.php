<?php

namespace frontend\modules\cp\controllers;

use common\models\Paid;
use common\models\PaidWorker;
use common\models\search\PaidSearch;
use common\models\search\PaidWorkerSearch;
use common\models\search\SaleSearch;
use common\models\Worker;
use common\models\search\WorkerSearch;
use frontend\components\Common;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use yii\web\UploadedFile;

/**
 * WorkerController implements the CRUD actions for Worker model.
 */
class WorkerController extends Controller
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
     * Lists all Worker models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new WorkerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Worker model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $searchSaleModel = new SaleSearch();
        $searchSaleModel->worker_id = $id;
        $dataSaleProvider = $searchSaleModel->search($this->request->queryParams);

        $searchPaidModel = new PaidWorkerSearch();
        $searchPaidModel->worker_id = $id;
        $dataPaidProvider = $searchPaidModel->search($this->request->queryParams);


        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchSaleModel' => $searchSaleModel,
            'dataSaleProvider' => $dataSaleProvider,
            'searchPaidModel' => $searchPaidModel,
            'dataPaidProvider' => $dataPaidProvider,
        ]);
    }

    /**
     * Creates a new Worker model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Worker();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->register_id = Yii::$app->user->id;
                $model->modify_id = Yii::$app->user->id;
                if($model->image = UploadedFile::getInstance($model,'image')){
                    $name = 'avatar/'.microtime(true).'.'.$model->image->extension;
                    $model->image->saveAs(Yii::getAlias('@frontend').'/web/upload/'.$name);
                    $model->image = $name;
                }else{
                    $model->image = 'default/nophoto.png';
                }
                if($model->save()){
                    Yii::$app->session->setFlash('success','Ma`lumot muvoffaqiyatli saqlandi');
                }else{
                    Yii::$app->session->setFlash('error','Ma`lumotni saqlashda xatolik');
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->renderAjax('_form', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Worker model.
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
             $model->modify_id = Yii::$app->user->id;
            if($model->image = UploadedFile::getInstance($model,'image')){
                $name = 'avatar/'.microtime(true).'.'.$model->image->extension;
                $model->image->saveAs(Yii::getAlias('@frontend').'/web/upload/'.$name);
                $model->image = $name;
            }else{
                $model->image =$img;
            }
            if($model->save()){
                Yii::$app->session->setFlash('success','Ma`lumot muvoffaqiyatli saqlandi');
            }else{
                Yii::$app->session->setFlash('error','Ma`lumotni saqlashda xatolik');
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->renderAjax('_form', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Worker model.
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
     * Finds the Worker model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Worker the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Worker::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDeletepaying($id)
    {
        $model = PaidWorker::findOne($id);
        if($model){
            $model->status = -1;
            $model->save(false);
            Common::calcPriceWorker($model->worker_id);
            Yii::$app->session->setFlash('success','Qo`shilgan to`lov o`chirildi');
            return $this->redirect(['view', 'id' => $model->worker_id]);
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUpdatepaying($id){
        $model = PaidWorker::findOne($id);
        if($model){
            if($model->load($this->request->post())){
                $model->modify_id = Yii::$app->user->id;
                $model->save(false);
                Common::calcPriceWorker($model->worker_id);
                Yii::$app->session->setFlash('success','To`lov ma`lumotlarni o`zgartirildi');
                return $this->redirect(['view', 'id' => $model->worker_id]);
            }
            return $this->renderAjax('_paying', [
                'model'=>$model,
            ]);
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionPaying($id)
    {
        $model = new PaidWorker();
        $worker = $this->findModel($id);
        $model->worker_id = $worker->id;
        if($model->load($this->request->post())){
            $model->modify_id = Yii::$app->user->id;
            $model->register_id = Yii::$app->user->id;
            $model->worker_id = $worker->id;
            $model->save(false);
            Common::calcPriceWorker($model->worker_id);
            Yii::$app->session->setFlash('success','To`lov qabul qilindi');
            return $this->redirect(['view', 'id' => $model->worker_id]);
        }
        return $this->renderAjax('_paying', [
            'model'=>$model,
        ]);
    }
}
