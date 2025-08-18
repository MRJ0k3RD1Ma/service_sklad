<?php

namespace frontend\modules\cp\controllers;

use common\models\Transaction;
use common\models\search\TransactionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * TransactionController implements the CRUD actions for Transaction model.
 */
class TransactionController extends Controller
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
                        'ok'=>['POST'],
                        'no'=>['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Transaction models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TransactionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Transaction model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $err = false;
        if($model->state != 'DONE'){
            $data = [
                'octo_shop_id'=>Yii::$app->params['octo']['id'],
                'octo_secret'=>Yii::$app->params['octo']['secret'],
                'shop_transaction_id'=>$id,
            ];

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://secure.octo.uz/prepare_payment',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);

            if(curl_errno($curl)){
                $err = [
                    'success'=>false,
                    'error'=>0,
                    'message'=>'Bunday to`lov topilmadi'
                ];
            }else{
                $response = json_decode($response,true);
                if($response['status'] == 'succeeded'){
                    $err = [
                        'success'=>true,
                        'error'=>1,
                        'message'=>'To`lov bankga kelib tushgan'
                    ];
                }else{
                    $err = [
                        'success'=>false,
                        'error'=>0,
                        'message'=>'To`lov qilinmagan'
                    ];
                }
            }
            curl_close($curl);

        }


        return $this->render('view', [
            'model' => $model,
            'err'=>$err,
            'res'=>$response,
        ]);
    }

    /**
     * Creates a new Transaction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Transaction();

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
     * Updates an existing Transaction model.
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
     * Deletes an existing Transaction model.
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


    public function actionOk($id){
        $model = $this->findModel($id);
        $res = $this->deposit($model);
        if(is_array($res)){
            $model->state = 'DONE';
            $model->verify_id = Yii::$app->user->identity->id;
            $model->payment_id = $res['OperationId'];
            $model->save(false);
            Yii::$app->session->setFlash('success','Depozit muvoffaqiyatli yuborildi.');
            return $this->redirect(['view', 'id' => $model->id]);
        }else{
            Yii::$app->session->setFlash('error',$res);
            return $this->redirect(['view', 'id' => $model->id]);
        }
    }



    private function deposit(Transaction  $model){

        // check balans
        $hash = Yii::$app->params['hash'];
        $cashierpass = Yii::$app->params['cashierpass'];
        $cashdeskid = Yii::$app->params['cashdeskid'];


        $dt = gmdate("Y.m.d H:i:s");      // UTC format

        $confirm = md5("$cashdeskid:$hash");

        $step1 = hash("sha256", "hash=$hash&cashierpass=$cashierpass&dt=$dt");

        $step2 = md5("dt=$dt&cashierpass=$cashierpass&cashdeskid=$cashdeskid");

        $sign = hash("sha256", $step1 . $step2);

        $baseUrl = "https://partners.servcul.com/CashdeskBotAPI";
        $url = "$baseUrl/Cashdesk/$cashdeskid/Balance?confirm=$confirm&dt=" . urlencode($dt);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "sign: $sign"
        ]);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            $err =  curl_error($ch);
            curl_close($ch);
            return "cURL error: " . $err;
        } else {
            $response = json_decode($response,true);

            if(array_key_exists('Limit',$response) and $response['Limit'] >= $model->price){
                curl_close($ch);
                return $this->payDeposit($model);
            }else{
                curl_close($ch);

                return "Kassada mablag` yetarli emas";
            }

        }
    }

    private function payDeposit(Transaction $model){
        $hash = Yii::$app->params['hash'];
        $cashierpass = Yii::$app->params['cashierpass'];
        $cashdeskid = Yii::$app->params['cashdeskid'];

        $userId = $model->wallet->number;
        $summa = (float)$model->price;
        $lng = "ru";

        $confirm = md5("$userId:$hash");

        $step1 = hash("sha256", "hash=$hash&lng=$lng&userid=$userId");

        $step2 = md5("summa=$summa&cashierpass=$cashierpass&cashdeskid=$cashdeskid");

        $sign = hash("sha256", $step1 . $step2);

        $baseUrl = "https://partners.servcul.com/CashdeskBotAPI";
        $url = "$baseUrl/Deposit/$userId/Add";

        $data = [
            "cashdeskId" => (int)$cashdeskid,
            "lng" => $lng,
            "summa" => $summa,
            "confirm" => $confirm
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            "sign: $sign"
        ]);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $err =  curl_error($ch);
            curl_close($ch);

            return "cURL xatosi: " . $err;
        } else {
            $response = json_decode($response,true);

            if(array_key_exists('Success',$response) and $response['Success'] == true){
                return $response;

            }else{
                return "Pulni depozit qilishda xatolik";
            }
        }

    }


    /**
     * Finds the Transaction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Transaction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Transaction::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
