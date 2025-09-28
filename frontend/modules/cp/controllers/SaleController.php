<?php

namespace frontend\modules\cp\controllers;

use common\models\Product;
use common\models\Sale;
use common\models\SaleLog;
use common\models\search\SaleSearch;
use frontend\components\Common;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
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
                        'changestate'=>['POST'],
                        'closecontract'=>['POST']
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

        return $this->render('index', [
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

    /**
     * Creates a new Sale model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Sale();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->state = 'NEW';
                $cid = Sale::find()->filterWhere(['like','date',date('Y-')])->max('code_id');
                if(!$cid){
                    $cid = 0;
                }
                $cid ++;
                $model->code_id = $cid;
                $model->code = date('y').$cid;
                $model->price = $model->price_per * $model->volume_estimated;
                $model->register_id = Yii::$app->user->id;
                $model->modify_id = Yii::$app->user->id;
                if($model->save()){
                    // create log
                    $log = new SaleLog();
                    $log->sale_id = $model->id;
                    $log->register_id = Yii::$app->user->id;
                    $log->state = 'NEW';
                    $log->save(false);


                    Yii::$app->session->setFlash('success','Ma`lumot muvoffaqiyatli saqlandi');
                }else{
                    Yii::$app->session->setFlash('error','Ma`lumotni saqlashda xatolik');
                }
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

        if ($this->request->isPost && $model->load($this->request->post())) {
             $model->modify_id = Yii::$app->user->id;
            $model->price = $model->price_per * $model->volume_estimated;
            if($model->save()){
                // create log
                $log = new SaleLog();
                $log->sale_id = $model->id;
                $log->register_id = Yii::$app->user->id;
                $log->state = 'UPDATED';
                $log->save(false);
                Yii::$app->session->setFlash('success','Ma`lumot muvoffaqiyatli saqlandi');
            }else{
                Yii::$app->session->setFlash('error','Ma`lumotni saqlashda xatolik');
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionGetproductprice($id){
        if($model = Product::findOne($id)){
            return json_encode([
                'price'=>$model->price,
                'min_price'=>$model->volume_price,
                'min_volume'=>$model->min_volume,
                'price_worker'=>$model->price_worker
            ]);
        }
        return json_encode([
            'price'=>0,
            'min_price'=>0,
            'min_volume'=>0,
            'price_worker'=>0
        ]);
    }

    public function actionChangestate($id){
        $model = $this->findModel($id);
        if($model->state == 'NEW'){
            $model->state = 'RUNNING';
            $model->modify_id = Yii::$app->user->id;
            $model->save(false);
            $log = new SaleLog();
            $log->sale_id = $model->id;
            $log->register_id = Yii::$app->user->id;
            $log->state = 'RUNNING';
            $log->save(false);
            Yii::$app->session->setFlash('success','Ushbu shartnoma bo`yicha ish boshlandi');
        }else{
            Yii::$app->session->setFlash('error','Bu amalni bajarib bo`lmadi');
        }
        return $this->redirect(['view', 'id' => $model->id]);
    }

    public function actionClosecontract($id){
        $model = $this->findModel($id);
        if($model->state != 'DONE'){
            $model->modify_id = Yii::$app->user->id;
            $model->state = 'CANCELLED';
            $model->save(false);
            $log = new SaleLog();
            $log->sale_id = $model->id;
            $log->register_id = Yii::$app->user->id;
            $log->state = 'CANCELLED';
            $log->save(false);
            Yii::$app->session->setFlash('success','Ushbu shartnoma bekor qilindi');
        }else{
            Yii::$app->session->setFlash('error','Bu amalni bajarib bo`lmadi');

        }

        return $this->redirect(['view', 'id' => $model->id]);
    }

    public function actionDone($id)
    {
        $model = $this->findModel($id);
        if($model->load($this->request->post())){
            $model->modify_id = Yii::$app->user->id;
            $model->price = $model->volume * $model->price_per;
            $model->total_price_worker = $model->price_worker * $model->volume;
            $model->state = 'DONE';
            $model->save(false);
            $log = new SaleLog();
            $log->sale_id = $model->id;
            $log->register_id = Yii::$app->user->id;
            $log->state = 'COMPLETED';
            $log->save(false);
            // brigadirga pulni hisobiga yozib qo'yish
            Common::calcPriceClient($model->client_id);
            Common::calcPriceWorker($model->worker_id);
            Yii::$app->session->setFlash('success','Ushbu shartnoma bo`yicha ish to`liq yakunlandi');
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->renderAjax('done', [
            'model'=>$model
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
        $model->save(false);
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
}
