<?php

namespace frontend\modules\cp\controllers;

use common\models\Paid;
use common\models\PaidClient;
use frontend\components\Common;
use Yii;
use common\models\Sale;
use common\models\SaleProduct;
use common\models\search\SaleCreditSearch;
use common\models\search\SaleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SaleController implements the CRUD actions for Sale model.
 */
class SaleController extends Controller
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
     * Lists all Sale models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SaleSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $umumiy_tushum = 0;
        $start = $searchModel->period_start;
        $end = $searchModel->period_end;
        $paid = Sale::find()->where(['status'=>1]);
        if($start){
            $paid->andWhere(['>=','date(created)',$start]);
        }
        if($end){
            $paid->andWhere(['<=','date(created)',$end]);
        }
        $umumiy_tushum = $paid->sum('price');
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'umumiy_tushum' => $umumiy_tushum,

        ]);
    }

    public function actionCredit()
    {
        $searchModel = new SaleCreditSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('credit', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }

    /**
     * Displays a single Sale model.
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


    public function actionPaid($id)
    {
        $model = new Paid();
        $model->register_id = Yii::$app->user->id;
        $model->modify_id = Yii::$app->user->id;
        $model->sale_id = $id;


        if($model->load($this->request->post())){
            // create paid yaratish va client_paid yaratish va
            // clientning balansidan kamaytirish sotilgan mahsulotdan kamaytirish
            if($model->save()){
                $sale = Sale::findOne(['id'=>$id]);
                if($sale->credit < $model->price){
                    $sale->credit = 0;
                    $sale->debt = $sale->price;
                }else{
                    $sale->credit = $sale->credit - $model->price;
                    $sale->debt += $sale->price;
                }

                $sale->save(false);

                $client = $sale->client[0];

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

    /**
     * Creates a new Sale model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Sale();

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
     * Updates an existing Sale model.
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
     * Deletes an existing Sale model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = -1;
        if($model->save(false)){
            \Yii::$app->session->setFlash('success','Muvoffaqiyatli o`chirildi');
        }else{
            \Yii::$app->session->setFlash('error','O`chirishda xatolik');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Sale model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Sale the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sale::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



    public function actionUpdatepro($id)
    {

        $model = SaleProduct::findOne(['id'=>$id]);
        if ($this->request->isPost && $model->load($this->request->post())) {

            $sale = $model->sale;
            $sale->price = $sale->price - $model->price + $model->cnt * $model->price;
            $model->cnt_price = $model->cnt * $model->price;
            $sale->debt = $sale->price;
            $sale->save(false);
            if($model->save()){
                \Yii::$app->session->setFlash('success','Muvoffaqiyatli saqlandi');
            }else{
                \Yii::$app->session->setFlash('error','Saqlashda xatolik');
            }

            return $this->redirect(['view', 'id' => $model->sale_id]);
        }

        return $this->renderAjax('_updatepro', [
            'model' => $model,
        ]);


    }

    public function actionDeletepro($id)
    {
        $model = SaleProduct::findOne(['id'=>$id]);
        $sale_id = $model->sale_id;
        $sale = $model->sale;
        $sale->price = $sale->price - $model->cnt_price;
        $sale->debt = $sale->price;
        $sale->save(false);
        if($model->delete()){
            \Yii::$app->session->setFlash('success','Muvoffaqiyatli o`chirildi');
        }else{
            \Yii::$app->session->setFlash('error','O`chirishda xatolik');
        }
        return $this->redirect(['view','id'=>$sale_id]);
    }


}

