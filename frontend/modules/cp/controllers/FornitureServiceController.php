<?php

namespace frontend\modules\cp\controllers;

use common\models\FornitureService;
use common\models\Goods;
use common\models\GoodsGroup;
use common\models\Paid;
use common\models\PaidClient;
use common\models\Sale;
use common\models\SaleProduct;
use common\models\search\FornitureServiceSearch;
use common\models\Visit;
use frontend\components\Common;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FornitureServiceController implements the CRUD actions for FornitureService model.
 */
class FornitureServiceController extends Controller
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
     * Lists all FornitureService models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new FornitureServiceSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FornitureService model.
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
     * Creates a new FornitureService model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new FornitureService();
        $code_id = FornitureService::find()->filterWhere(['like','created',date('Y-m')])->max('code_id');
        if (!$code_id) {
            $code_id = 0;
        }
        $code_id++;
        $model->code_id = $code_id;
        $model->code = date('ym').$code_id;
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->user_id = Yii::$app->user->id;
                $model->register_id = Yii::$app->user->id;
                $model->modify_id = Yii::$app->user->id;

                $code_id = FornitureService::find()->filterWhere(['like','created',date('Y-m')])->max('code_id');
                if (!$code_id) {
                    $code_id = 0;
                }
                $code_id++;
                $model->code_id = $code_id;
                $model->code = 'F'.date('ym').$code_id;
                //check client and register
                if($model->client_id == -1){
                    $model->client_phone = Common::getphone($model->client_phone);
                    if($client = \common\models\Client::find()->where(['phone'=>$model->client_phone])->one()) {
                        $model->client_id = $client->id;
                    }else{
                        $client = new \common\models\Client();
                        $client->name = $model->client_name;
                        $client->phone = $model->client_phone;
                        $client->phone_two = $model->phone;
                        $client->balans = 0;
                        $client->debt = 0;
                        $client->credit = 0;
                        $client->status = 1;
                        if($client->save(false)){
                            $model->client_id = $client->id;
                        }
                    }
                }

                // register service
                $model->price = 0;
                $model->state = 'NEW';
                if($model->debt > 0){
                    $model->credit = $model->price_agreed - $model->debt;
                }
                // create sale
                $sale = new Sale();
                $sale->type = 'FORNITURE';
                $sale->user_id = Yii::$app->user->id;
                $sale->price = $model->price_agreed;
                $sale->credit = $model->price_agreed - $model->debt;
                $sale->debt = $model->debt;
                $sale->status = 1;
                $sale->code = $model->code;
                $sale->code_id = 0;
                $sale->save(false);
                $model->sale_id = $sale->id;
                if($model->save(false)){

                    // create payment
                    if($model->debt > 0){
                        $paid = new Paid();
                        $paid->sale_id = $sale->id;
                        $paid->payment_id = $model->payment_id;
                        $paid->date = date('Y-m-d');
                        $paid->price = $model->debt;
                        $paid->type = 1;
                        $paid->status = 1;
                        $paid->register_id = $model->register_id;
                        $paid->modify_id = $model->modify_id;
                        $paid->save(false);
                        $client_paid = new PaidClient();
                        $client_paid->client_id = $model->client_id;
                        $client_paid->paid_id = $paid->id;
                        $client_paid->save(false);
                    }
                    // create workers
                    foreach ($model->worker_list as $worker_id){
                        $worker = new \common\models\FornitureServiceWorker();
                        $worker->service_id = $model->id;
                        $worker->user_id = $worker_id;
                        $worker->register_id = $model->register_id;
                        $worker->modify_id = $model->modify_id;
                        $worker->save(false);
                    }
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
     * Updates an existing FornitureService model.
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

    public function actionChangestate($id){
        $model = $this->findModel($id);
        $old = $model->state;
        if($model->state == 'NEW'){
            $model->state = 'CALC';
        }elseif($model->state == 'CALC'){
            $model->state = 'RUNNING';
        }else if($model->state == 'RUNNING'){
            $model->state = 'DONE';
        }else if($model->state == 'DONE'){
            $model->state = 'COMPLETED';
        }
        $new = $model->state;
        $model->modify_id = Yii::$app->user->id;

        $model->save(false);
        // create history
        $history = new \common\models\FornitureServiceHistory();
        $history->service_id = $model->id;
        $history->old_state = $old;
        $history->state = $new;
        $history->user_id = Yii::$app->user->id;
        $history->save(false);
        return $this->redirect(['view','id'=>$id]);
    }

    public function actionCancel($id){
        $model = $this->findModel($id);
        $old = $model->state;
        $model->state = 'CANCELED';
        $model->modify_id = Yii::$app->user->id;
        $new = $model->state;
        $history = new \common\models\FornitureServiceHistory();
        $history->service_id = $model->id;
        $history->old_state = $old;
        $history->state = $new;
        $history->user_id = Yii::$app->user->id;
        $history->save(false);
        $model->save(false);
        return $this->redirect(['view','id'=>$id]);
    }

    /**
     * Deletes an existing FornitureService model.
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

    public function actionCreategoods($id)
    {
        $cat = GoodsGroup::find()->where(['type'=>1,'status'=>1])->all();


        return $this->renderAjax('_creategoods', [
            'id' => $id,
            'cat' => $cat,
            'type'=>1,
        ]);

    }

    public function actionGetgoods($id,$group_id)
    {
        $goods = Goods::find()->where(['type'=>1,'status'=>1,'group_id'=>$group_id])->all();
        return $this->renderAjax('_getgoods', [
            'id' => $id,
            'goods' => $goods,
            'type'=>1,
        ]);
    }

    public function actionUpdatecount($id,$goods_id,$cnt)
    {
        $visit = FornitureService::findOne($id);
        $sale = $visit->sale;
        $sale_product = SaleProduct::find()->where(['id'=>$goods_id])->one();
        $goods = $sale_product->product;
        $old_cnt = 0;
        if($old_cnt = SaleProduct::find()->where(['id'=>$goods_id])->one()){
            $old_cnt = $old_cnt->cnt;
        }
        $sale->price = $goods->price * $cnt;
//            $sale->debt += $goods->price;
        $sale->credit = $goods->price * $cnt;
        $sale->save(false);
        $visit->price = $goods->price * $cnt;
//            $visit->debt += $goods->price;
        $visit->credit = $goods->price * $cnt;
        $visit->save(false);
        $goods->remainder = $goods->remainder - $cnt + $old_cnt;
        $goods->sale = $goods->sale + $cnt - $old_cnt;
        $goods->save(false);

        $sale_product->cnt = $cnt;
        $sale_product->price = $goods->price;
        $sale_product->cnt_price = $goods->price * $cnt;
        $sale_product->save(false);
        Yii::$app->session->setFlash('success','Muvaffaqiyatli saqlandi');
        return 1;

    }

    public function actionAddgoods($id,$goods_id)
    {
        $visit = FornitureService::findOne($id);
        $sale = $visit->sale;
        $goods = Goods::findOne($goods_id);
        if($goods->remainder == $goods->remainder){
            $sale->price += $goods->price;
//            $sale->debt += $goods->price;
            $sale->credit += $goods->price;
            $sale->save(false);
            $visit->price += $goods->price;
//            $visit->debt += $goods->price;
            $visit->credit += $goods->price;
            $visit->save(false);
            $goods->remainder -= 1;
            $goods->sale += 1;
            $goods->save(false);

            $sale_product = new SaleProduct();
            if($sale_product = SaleProduct::find()->where(['sale_id'=>$sale->id,'product_id'=>$goods_id])->one()) {
                $sale_product->cnt += 1;
                $sale_product->price = $goods->price;
                $sale_product->cnt_price += $goods->price;
                $sale_product->save(false);
            }else{
                $sale_product = new SaleProduct();
                $sale_product->sale_id = $sale->id;
                $sale_product->product_id = $goods_id;
                $sale_product->cnt = 1;
                $sale_product->price = $goods->price;
                $sale_product->cnt_price += $goods->price;
                $sale_product->user_id = Yii::$app->user->id;
                $sale_product->save(false);
            }
        }elseif($goods->remainder == $goods->remainder){
            $rem = $goods->remainder;
            $sale->price += $goods->price * $rem;
//            $sale->debt += $goods->price;
            $sale->credit += $goods->price * $rem;
            $sale->save(false);
            $visit->price += $goods->price * $rem;
//            $visit->debt += $goods->price;
            $visit->credit += $goods->price * $rem;
            $visit->save(false);
            $goods->remainder -= $rem;
            $goods->sale += $rem;
            $goods->save(false);

            $sale_product = new SaleProduct();
            if($sale_product = SaleProduct::find()->where(['sale_id'=>$sale->id,'product_id'=>$goods_id])->one()) {
                $sale_product->cnt += $rem;
                $sale_product->price = $goods->price * $rem;
                $sale_product->cnt_price += $goods->price * $rem;
                $sale_product->save(false);
            }else{
                $sale_product = new SaleProduct();
                $sale_product->sale_id = $sale->id;
                $sale_product->product_id = $goods_id;
                $sale_product->cnt = $rem;
                $sale_product->price = $goods->price * $rem;
                $sale_product->cnt_price += $goods->price * $rem;
                $sale_product->user_id = Yii::$app->user->id;
                $sale_product->save(false);
            }
        }else{
            Yii::$app->session->setFlash('error','Mahsulotlar yetarli emas');
        }
    }

    public function actionCreateservice($id)
    {
        $cat = GoodsGroup::find()->where(['type'=>2,'status'=>1])->all();


        return $this->renderAjax('_creategoods', [
            'id' => $id,
            'cat' => $cat,
            'type'=>2,
        ]);

    }

    public function actionGetservice($id,$group_id)
    {
        $goods = Goods::find()->where(['type'=>2,'status'=>1,'group_id'=>$group_id])->all();
        return $this->renderAjax('_getgoods', [
            'id' => $id,
            'goods' => $goods,
            'type'=>2,
        ]);
    }

    public function actionAddservice($id,$goods_id)
    {
        $visit = FornitureService::findOne($id);
        $sale = $visit->sale;
        $goods = Goods::findOne($goods_id);

        $sale->price += $goods->price;
        $sale->credit += $goods->price;
        $sale->save(false);
        $visit->price += $goods->price;
        $visit->credit += $goods->price;
        $visit->save(false);
        $goods->save(false);

        $sale_product = new SaleProduct();
        if($sale_product = SaleProduct::find()->where(['sale_id'=>$sale->id,'product_id'=>$goods_id])->one()) {
            $sale_product->cnt += 1;
            $sale_product->price = $goods->price;
            $sale_product->cnt_price += $goods->price;
            $sale_product->save(false);
        }else{
            $sale_product = new SaleProduct();
            $sale_product->sale_id = $sale->id;
            $sale_product->product_id = $goods_id;
            $sale_product->cnt = 1;
            $sale_product->price = $goods->price;
            $sale_product->cnt_price += $goods->price;
            $sale_product->user_id = $visit->user_id;
            $sale_product->save(false);
        }
    }


    /**
     * Finds the FornitureService model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return FornitureService the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FornitureService::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
