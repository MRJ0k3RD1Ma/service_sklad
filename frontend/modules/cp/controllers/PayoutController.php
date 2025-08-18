<?php

namespace frontend\modules\cp\controllers;

use common\models\Payout;
use common\models\search\PayoutSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
/**
 * PayoutController implements the CRUD actions for Payout model.
 */
class PayoutController extends Controller
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
     * Lists all Payout models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PayoutSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Payout model.
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
     * Creates a new Payout model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Payout();

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
     * Updates an existing Payout model.
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
     * Deletes an existing Payout model.
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
     * Finds the Payout model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Payout the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Payout::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionOk($id){
        $model = $this->findModel($id);
        $res = $this->payout($model);
        if(is_array($res)){
            $model->state = 'PAYOUTED';
            $model->approved_id = Yii::$app->user->identity->id;
            $model->save(false);
            Yii::$app->session->setFlash('success','Pul kassaga kelib tushdi');
            return $this->redirect(['view', 'id' => $model->id]);
        }else{
            Yii::$app->session->setFlash('error',$res);
            return $this->redirect(['view', 'id' => $model->id]);
        }
    }

    private function payout(Payout $model){


        // check balans
        $hash = Yii::$app->params['hash'];
        $cashierpass = Yii::$app->params['cashierpass'];
        $cashdeskid = Yii::$app->params['cashdeskid'];

        $userId = $model->wallet->number;
        $lng = "ru";
        $code = $model->code;

        $confirm = md5("$userId:$hash");
        $step1 = hash("sha256", "hash=$hash&lng=$lng&userid=$userId");

        $step2 = md5("code=$code&cashierpass=$cashierpass&cashdeskid=$cashdeskid");

        $sign = hash("sha256", $step1 . $step2);

        $baseUrl = "https://partners.servcul.com/CashdeskBotAPI";
        $url = "$baseUrl/Deposit/$userId/Payout";

        $data = [
            "cashdeskId" => (int)$cashdeskid,
            "lng" => $lng,
            "code" => $code,
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
            $err = curl_errno($ch);
            curl_close($ch);
            return "cURL xatosi: " . $err;
        } else {
            $response = json_decode($response,true);

            curl_close($ch);
            if(array_key_exists('Success',$response) and $response['Success'] == true){
                $model->price = $response['Summa'];
                $model->save(false);
                return $response;
            }else{

                return "Pulni chiqarishda xatolik";
            }
        }

    }



}
