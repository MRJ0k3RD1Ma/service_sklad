<?php

namespace frontend\modules\cp\controllers;

use common\models\search\ComeSearch;
use common\models\search\SupplerPaidSearch;
use common\models\search\SupplerReturnSearch;
use common\models\Suppler;
use common\models\search\SupplerSearch;
use common\models\SupplerPaid;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
/**
 * SupplerController implements the CRUD actions for Suppler model.
 */
class SupplerController extends Controller
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
     * Lists all Suppler models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SupplerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDebt()
    {
        $searchModel = new SupplerSearch();
        $searchModel->type = 'debt';
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCredit()
    {
        $searchModel = new SupplerSearch();
        $searchModel->type = 'credit';
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Suppler model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $searchModel = new ComeSearch();
        $searchModel->suppler_id = $id;
        $dataProvider = $searchModel->search($this->request->queryParams);

        $ssearchModel = new SupplerPaidSearch();
        $ssearchModel->suppler_id = $id;
        $sdataProvider = $ssearchModel->search($this->request->queryParams);

        $searchModelReturn = new SupplerReturnSearch();
        $searchModelReturn->suppler_id = $id;
        $dataProviderReturn = $searchModelReturn->search($this->request->queryParams);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'ssearchModel' => $ssearchModel,
            'sdataProvider' => $sdataProvider,
            'searchModelReturn' => $searchModelReturn,
            'dataProviderReturn' => $dataProviderReturn,
        ]);
    }

    /**
     * Creates a new Suppler model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Suppler();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

               $model->phone = \frontend\components\Common::getphone($model->phone);
                if($suppler = Suppler::findOne(['phone'=>$model->phone])){
                    Yii::$app->session->setFlash('error','Bu raqam allaqachon ro`yxatdan o`tkazilgan');
                    return $this->redirect(['view','id'=>$suppler->id]);
                }

                Yii::$app->session->setFlash('success','Amal muvaffaqiyatli bajarildi');
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                Yii::$app->session->setFlash('error','Ma`lumotni o`zgartirishda xatolik. Iltimos qayta urinib ko`ring.');
                return $this->redirect(['index',]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    public function actionPay($id)
    {
        $model = new SupplerPaid();
        $model->suppler_id = $id;
        if($model->load($this->request->post())){
            $model->register_id = Yii::$app->user->id;
            $model->modify_id = Yii::$app->user->id;

            if($model->save()) {

                $suppler = $model->suppler;
                $suppler->balans -= $model->price;
                $suppler->debt += $model->price;
                $suppler->save(false);

                Yii::$app->session->setFlash('success', 'Amal muvaffaqiyatli bajarildi');
            }else{
                Yii::$app->session->setFlash('error','Ma`lumotni salasgda xatolik. Iltimos qayta urinib ko`ring.');
            }
            return $this->redirect(['view', 'id' => $id]);

        }
        return $this->renderAjax('_pay',[
            'model'=>$model
        ]);

    }


    /**
     * Updates an existing Suppler model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {

            $model->phone = \frontend\components\Common::getphone($model->phone);
            if($suppler = Suppler::find()->where(['phone'=>$model->phone])->andWhere(['!=','id',$model->id])->one()){
                Yii::$app->session->setFlash('error','Bu raqam allaqachon ro`yxatdan o`tkazilgan');
                return $this->redirect(['view','id'=>$suppler->id]);
            }

            if($model->save()) {
                Yii::$app->session->setFlash('success', 'Amal muvaffaqiyatli bajarildi');
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                Yii::$app->session->setFlash('error','Ma`lumotni o`zgartirishda xatolik. Iltimos qayta urinib ko`ring.');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing Suppler model.
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
     * Finds the Suppler model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Suppler the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Suppler::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
