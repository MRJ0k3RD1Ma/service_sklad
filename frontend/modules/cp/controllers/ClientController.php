<?php

namespace frontend\modules\cp\controllers;

use common\models\Client;
use common\models\search\CardSearch;
use common\models\search\ClientSearch;
use common\models\search\PayoutSearch;
use common\models\search\TransactionSearch;
use common\models\search\WalletSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
     * Lists all Client models.
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

    /**
     * Displays a single Client model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $searchDepositModel = new TransactionSearch();
        $searchDepositModel->client_id = $id;
        $dataDepositProvider = $searchDepositModel->search($this->request->queryParams);

        $searchPayoutModel = new PayoutSearch();
        $searchPayoutModel->client_id = $id;
        $dataPayoutProvider = $searchPayoutModel->search($this->request->queryParams);


        $searchWalletModel = new WalletSearch();
        $searchWalletModel->client_id = $id;
        $dataWalletProvider = $searchWalletModel->search($this->request->queryParams);

        $searchCardModel = new CardSearch();
        $searchCardModel->client_id = $id;
        $dataCardProvider = $searchCardModel->search($this->request->queryParams);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchDepositModel' => $searchDepositModel,
            'dataDepositProvider' => $dataDepositProvider,
            'searchPayoutModel' => $searchPayoutModel,
            'dataPayoutProvider' => $dataPayoutProvider,
            'searchWalletModel' => $searchWalletModel,
            'dataWalletProvider' => $dataWalletProvider,
            'searchCardModel' => $searchCardModel,
            'dataCardProvider' => $dataCardProvider,
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
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
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

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
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
        $this->findModel($id)->delete();

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
