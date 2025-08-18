<?php

namespace frontend\modules\cp\controllers;

use common\models\Client;
use common\models\ClientCar;
use common\models\Goods;
use common\models\GoodsGroup;
use common\models\Paid;
use common\models\PaidClient;
use common\models\Sale;
use common\models\SaleClient;
use common\models\SaleCredit;
use common\models\SaleProduct;
use common\models\Visit;
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
 * VisitController implements the CRUD actions for Visit model.
 */
class VisitController extends Controller
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
     * Lists all Visit models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new VisitSearch();
        $searchModel->state_param = 1;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionList()
    {
        $searchModel = new VisitSearch();
        $searchModel->state = 'COMPLETED';
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionNotprinted()
    {
        $searchModel = new VisitSearch();
        $searchModel->state = 'COMPLETED';
        $searchModel->is_print = 0;
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single Visit model.
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



    public function actionVisitprint($id){
        $model = $this->findModel($id);
        $model->is_print = 1;
        $model->save(false);
        return $this->renderAjax('_print',[
            'model'=>$model
        ]);
    }

    public function actionCredit($id)
    {
        $model = $this->findModel($id);
        $credit = new SaleCredit();
        $credit->sale_id = $model->id;
        $credit->price = $model->sale->credit;
        $credit->status = 1;
        $credit->state = 1;
        $credit->user_id = Yii::$app->user->id;
        $credit->client_id = $model->client_id;
        if($credit->load(Yii::$app->request->post())){
            $credit->call_date = date('Y-m-d',$credit->call_date);
            if($credit->save()){
               Yii::$app->session->setFlash('success','Qoldiq summa qarz qilib yozib qo`yildi');
            }else{
                Yii::$app->session->setFlash('error','Qoldiq summa qarz qilib yozishda xatolik');
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->renderAjax('_credit',[
            'model'=>$model,
            'credit'=>$credit
        ]);
    }

    public function actionPaid($id)
    {
        $model = new Paid();
        $model->register_id = Yii::$app->user->id;
        $model->modify_id = Yii::$app->user->id;
        $visit = $this->findModel($id);
        $model->sale_id = $visit->id;

        if($model->load($this->request->post())){
            // create paid yaratish va client_paid yaratish va
            // clientning balansidan kamaytirish sotilgan mahsulotdan kamaytirish
            if($model->save()){

                $sale = $visit->sale;
                if($sale->credit < $model->price){
                    $sale->credit = 0;
                    $sale->debt = $sale->price;
                }else{
                    $sale->credit = $sale->credit - $model->price;
                    $sale->debt += $sale->price;
                }

                $sale->save(false);

                if($visit->credit < $model->price){
                    $visit->credit = 0;
                    $visit->debt = $visit->price;
                }else{
                    $visit->credit = $visit->credit - $model->price;
                    $visit->debt += $visit->price;
                }

                $visit->save(false);

                $client = $visit->client;

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
     * Creates a new Visit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Visit();
        $model->date = date('Y-m-d');
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->car_model = mb_strtoupper($model->car_model);
                $model->car_number = mb_strtoupper($model->car_number);
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
                    $model->image = null;
                }
                // sale yaratiladi
                $sale = new Sale();
                $sale->user_id = Yii::$app->user->id;
                $sale->price = 0;
                $sale->debt = 0;
                $sale->credit = 0;
                $sale->status = 1;
                $sale->type = 'SERVICE';
                $code = Sale::find()->filterWhere(['like','created',date('Y-m')])->max('code_id');
                if(!$code){
                    $code = 0;
                }
                $code ++;
                $sale->code_id = $code;
                $sale->code = date('ym').$code;
                if($sale->save(false)){
                    // client yaratiladi
                    $client = null;
                    if($model->client_id != -1) {
                        $client = $model->client;
                        if($model->image){
                            $client->image = $model->image;
                        }
                        $client->save(false);
                    }else{
                        $client = new Client();
                        $client->name = $model->client_name;
                        $client->phone = $model->client_phone;
                        $client->status = 1;
                        if($model->image){
                            $client->image = $model->image;
                        }

                        $client->type_id = 1;
                        if($client->save(false)){
                            $model->client_id = $client->id;
                        }
                    }
                    // client car yaratiladi
                    $car = null;



                    if($model->car_id != -1) {
                        $car = $model->car;
                    }else{
                        $car = new ClientCar();
                        $car->client_id = $model->client_id;
                        $car->number = $model->car_number;
                        $car->model = $model->car_model;
                        $car->run = $model->car_run;
                        $car->status = 1;
                        $car->call_date = date('Y-m-d',strtotime($model->call_date));
                        $car->ads = $model->ads;
                        $car->last_visit = date('Y-m-d',strtotime($model->date));
                        if($car->save(false)){
                            $model->car_id = $car->id;
                        }
                    }
                    // sale client yaratiladi
                    $sale_client = new SaleClient();
                    $sale_client->sale_id = $sale->id;
                    $sale_client->client_id = $model->client_id;
                    if($sale_client->save(false)){
                        $model->sale_id = $sale->id;
                    }
                    // visit yaratiladi
                    $model->register_id = Yii::$app->user->id;
                    $model->modify_id = Yii::$app->user->id;
                    $model->status = 1;
                    if($model->save()){
                        Yii::$app->session->setFlash('success','Muvaffaqiyatli saqlandi');
                    }else{
                        Yii::$app->session->setFlash('error','Ma`lumotlarni saqlashda xatolik');
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




    public function actionSearchcar($number,$client_id)
    {
        $model = ClientCar::find()->where(['client_id'=>$client_id])->andFilterWhere(['like','number',$number])->all();
        $res = "";
        foreach ($model as $item){
            $res .= "<li data-id='{$item->id}' data-number='{$item->number}' data-model='{$item->model}' data-run='{$item->run}'>{$item->number} - {$item->model} - {$item->run} km</li>";
        }
        return $res;
    }

    /**
     * Updates an existing Visit model.
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
     * Deletes an existing Visit model.
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
     * Finds the Visit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Visit the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Visit::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionStartservice($id)
    {
        $model = Visit::findOne($id);
        $model->state = 'RUNNING';
        $model->save(false);
        return $this->redirect(['view','id'=>$id]);
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
        $visit = Visit::findOne($id);
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
        $visit = Visit::findOne($id);
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
        $visit = Visit::findOne($id);
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


    public function actionEndservice($id)
    {
        $visit = Visit::findOne($id);
        $model = $visit->car;
        if($model->load($this->request->post())){
            $model->save(false);
            $visit->state = 'COMPLETED';
            $visit->save(false);

            // mijozga qarzdorlik yozish

            return $this->redirect(['view','id'=>$id]);

        }
        return $this->renderAjax('_endservice', [
            'model' => $model,
            'visit'=>$visit
        ]);

    }

}

