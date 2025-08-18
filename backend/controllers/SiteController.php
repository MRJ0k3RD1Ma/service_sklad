<?php

namespace backend\controllers;

use backend\models\LoginForm;
use backend\models\User;
use common\models\Card;
use common\models\Client;
use common\models\Payout;
use common\models\Telefy;
use common\models\Transaction;
use common\models\Wallet;
use Yii;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'corsFilter'=>[
                'class' => Cors::class,
            ],
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];

    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {

        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'options'=>[
                'class' => 'yii\rest\OptionsAction',
            ],
        ];
    }

    public function actionOcto($id, $octo_status){
        if($order = Transaction::find()->where(['id' => $id])->one()){
            if($octo_status == 'succeeded'){
                $order->state = 'CHECK';
            }

            $order->save(false);
        }
        Yii::$app->response->statusCode = 200;
        return [];
    }


    public function actionNotify(){
        $post = Yii::$app->request->post();


        if($order = Transaction::find()->where(['id' => $post['shop_transaction_id']])->one()){
             if($post['status'] == 'succeeded'){
                 $order->state = 'CHECK';
                 $order->save(false);
                 $this->sendMessage("OCTOdan pul tushdi. Pulni tekshirib depositga o'tkazishga ruhsat bering.");
             }

        }

    }


    public function actionIndex()
    {
        $post = $this->request->post();
        $method = $post['method'] ?? null;
        if($method && method_exists($this,$method)){
            return $this->$method($post);
        }
        Yii::$app->response->statusCode = 400;
        return [
            'error'=>true,
            'success'=>false,
            'message'=>'Method not found'
        ];
    }

    public function addUser($post)
    {
        $chatId = $post['chatId'] ?? null;
        $name = $post['name'] ?? null;
        if($chatId and $name){
            if($client = Client::find()->where(['chat_id'=>$chatId])->one()){
                $wallets = Wallet::find()->where(['status'=>1,'client_id'=>$client->id])->all();
                $data_wall = [];
                /* @var $wallet Wallet*/
                foreach ($wallets as $wallet){
                    $data_wall[] = [
                        'wallet_num'=>$wallet->number,
                        'valyuta'=>$wallet->valyuta,
                    ];
                }

                $cards = Card::find()->where(['status'=>1,'client_id'=>$client->id])->all();
                $data_card = [];
                /* @var $card Card*/
                foreach ($cards as $card){
                    if($card->expire_month < 10){
                        $card->expire_month = '0'.$card->expire_month;
                    }
                    $data_card[] = [
                        'cardNum'=>$card->number,
                        'srok'=>$card->expire_month.'/'.$card->expire_date
                    ];
                }
                return [
                    'success'=>true,
                    'name'=>$client->name,
                    'chat_id'=>$chatId,
                    'wallets'=>$data_wall,
                    'cards'=>$data_card,
                ];
            }else{
                $client = new Client();
                $client->name = $name;
                $client->chat_id = $chatId;
                $client->save();

                return [
                    'success'=>true,
                    'name'=>$client->name,
                    'chat_id'=>$chatId,
                    'wallets'=>[],
                    'cards'=>[],
                ];
            }
        }
        return [
            'error'=>true,
            'success'=>false,
            'message'=>'chatId and name must be required'
        ];
    }

    public function getUser($post)
    {
        $chatId = $post['chatId'] ?? null;
        if($chatId){
            if($client = Client::find()->where(['chat_id'=>$chatId])->one()){
                $wallets = Wallet::find()->where(['status'=>1,'client_id'=>$client->id])->all();
                $data_wall = [];
                /* @var $wallet Wallet*/
                foreach ($wallets as $wallet){
                    $data_wall[] = [
                        'wallet_num'=>$wallet->number,
                        'valyuta'=>$wallet->valyuta,
                    ];
                }

                $cards = Card::find()->where(['status'=>1,'client_id'=>$client->id])->all();
                $data_card = [];
                /* @var $card Card*/
                foreach ($cards as $card){
                    if($card->expire_month < 10){
                        $card->expire_month = '0'.$card->expire_month;
                    }
                    $data_card[] = [
                        'cardNum'=>$card->number,
                        'srok'=>$card->expire_month.'/'.$card->expire_date,
                    ];
                }
                return [
                    'success'=>true,
                    'name'=>$client->name,
                    'chat_id'=>$chatId,
                    'wallets'=>$data_wall,
                    'cards'=>$data_card,
                ];
            }else{

                return [
                    'error'=>true,
                    'success'=>false,
                    'message'=>'chatId not found'
                ];
            }
        }
        return [
            'error'=>true,
            'success'=>false,
            'message'=>'chatId must be required'
        ];
    }

    public function addCard($post){
//        chat_id, cardNum, srok
        $chatId = $post['chatId'] ?? null;
        $cardNumber = $post['cardNum'] ?? null;
        $srok = $post['srok'] ?? null;
        if($srok != null){
            $srok = '0/0';
            $srok = explode('/',$srok);
        }else{
            $srok = [0,0];
        }
        if($chatId and $cardNumber){

            if($client = Client::find()->where(['chat_id'=>$chatId])->one()){
                if(Card::find()->where(['client_id'=>$client->id,'number'=>$cardNumber])->exists()){
                    return [
                        'success'=>false,
                        'error'=>true,
                        'message'=>'card number already exists'
                    ];
                }
                $card = new Card();
                $card->client_id = $client->id;
                $card->number = $cardNumber;
                $card->expire_month = $srok[0];
                $card->expire_date = $srok[1];
                $card->save();
                return [
                    'success'=>true,
                ];
            }else{
                return [
                    'error'=>true,
                    'success'=>false,
                    'message'=>'chatId not found'
                ];
            }
        }
        return [
            'error'=>true,
            'success'=>false,
            'message'=>'chatId, cardNum and srok must be required'
        ];
    }

    public function addWallet($post){
        $chatId = $post['chatId'] ?? null;
        $wallet_number = $post['wallet_num'] ?? null;
        if($chatId and $wallet_number){
            if($client = Client::find()->where(['chat_id'=>$chatId])->one()){
                if(Wallet::find()->where(['client_id'=>$client->id,'number'=>$wallet_number])->exists()){
                    return [
                        'success'=>false,
                        'error'=>true,
                        'message'=>'wallet number already exists'
                    ];
                }else{
                    $res = $this->getUserInfo($wallet_number);

                    if($res and $res['success']==true){
                        $wallet = new Wallet();
                        $wallet->client_id = $client->id;
                        $wallet->number = $wallet_number;
                        $wallet->name = $res['data']['Name'];
                        $wallet->valyuta = $res['data']['CurrencyId'].'';
                        if($res['data']['CurrencyId'] == 87){
                            if($wallet->save()){
                                return [
                                    'success'=>true,
                                    'error'=>false,
                                    'message'=>'wallet number added successfully'
                                ];
                            }else{
                                return [
                                    'success'=>false,
                                    'error'=>true,
                                    'message'=>$wallet->getErrors()
                                ];
                            }
                        }else{
                            return [
                                'success'=>false,
                                'error'=>true,
                                'message'=>'Wallet currency must be ID: 87; CODE: UZS'
                            ];
                        }


                    }
                    return [
                        'success'=>false,
                        'error'=>true,
                        'message'=>'wallet number not found'
                    ];
                }
            }else{
                return [
                    'success'=>false,
                    'error'=>true,
                    'message'=>'User not found'
                ];
            }


        }
        return [
            'success'=>false,
            'error'=>true,
            'message'=>'chatId and wallet_num must be required'
        ];
    }

    public function getGamer($post){
        $chatId = $post['chatId'] ?? null;
        $userId = $post['wallet_num'] ?? null;

        if($chatId and $userId){

            $res = $this->getUserInfo($userId);
            return $res;
        }
        return [
            'success'=>false,
            'error'=>false,
            'message'=>'chat id and wallet_num must be required'
        ];
    }

    public function getUserInfo($userId)
    {
        $hash = Yii::$app->params['hash'];
        $cashierpass = Yii::$app->params['cashierpass'];
        $cashdeskid = Yii::$app->params['cashdeskid'];

        $confirm = md5("$userId:$hash");

        $step1 = hash("sha256", "hash=$hash&userid=$userId&cashdeskid=$cashdeskid");

        $step2 = md5("userid=$userId&cashierpass=$cashierpass&hash=$hash");

        $sign = hash("sha256", $step1 . $step2);


        $baseUrl = "https://partners.servcul.com/CashdeskBotAPI";
        $url = "$baseUrl/Users/$userId?confirm=$confirm&cashdeskId=$cashdeskid";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "sign: $sign"
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            return [
                'success'=>false,
                'error'=>true,
                'message'=>curl_error($ch)
            ];
        } else {
            return [
                'success'=>true,
                'error'=>false,
                'data'=>json_decode($response,true)
            ];
        }

        curl_close($ch);

    }

    public function preparePayment($post)
    {
        $chatId = $post['chatId'] ?? null;
        $price = $post['price'] ?? null;
        $wallet_id = $post['wallet_id'] ?? null;
        /*if($price < 10000){
            return [
                'success'=>false,
                'error'=>true,
                'message'=>'To`lov 10 000 so`mdan kam bo`lmasligi kerak'
            ];
        }*/
        if($chatId and $price and $wallet_id){
            $client = Client::find()->where(['chat_id'=>$chatId])->one();
            $wallet = Wallet::find()->where(['client_id'=>$client->id,'id'=>$wallet_id,'status'=>1])->one();
            if($client and $wallet){
                $transaction = new Transaction();
                $transaction->client_id = $client->id;
                $transaction->wallet_id = $wallet_id;
                $transaction->price = $price;
                if($transaction->save(false)){
                    $data = [
                        "octo_shop_id"=> Yii::$app->params['octo']['id'],
                        "octo_secret"=> Yii::$app->params['octo']['secret'],
                        "shop_transaction_id"=> $transaction->id,
                        "auto_capture"=> true,
                        "test"=> true,
                        "init_time"=> date('Y-m-d H:i:s'),
                        "total_sum"=> $transaction->price,
                        "currency"=> "UZS",
                        "description"=> "Deposit qo`yish",
                        "payment_methods"=> [
                            ["method"=> "uzcard"],
                            ["method"=> "humo"],
                            ["method"=>'bank_card'],
                        ],
                        "return_url"=> Yii::$app->urlManager->createAbsoluteUrl(['/v1/octo','id'=>$transaction->id]),
                        "language"=> "uz"
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

                    curl_close($curl);
                    if($response){
                        $response = json_decode($response,true);
                        if($response['error'] == 0){
                            // create payment
                            $transaction->uuid = $response['data']['octo_payment_UUID'];
                            $transaction->save(false);
                            return [
                                'success'=>true,
                                'error'=>false,
                                'orderId'=>$transaction->id,
                                'payment_url'=>$response['data']['octo_pay_url'],
                            ];
                        }else{
                            return [
                                'success'=>false,
                                'error'=>true,
                                'message'=>$response['errorMessage']
                            ];
                        }
                    }else{
                        return [
                            'success'=>false,
                            'error'=>true,
                            'message'=>curl_error($curl)
                        ];
                    }
                }else{
                    return [
                        'succes'=>false,
                        'error'=>true,
                        'message'=>'Ko`zda tutilmagan xatolik'
                    ];
                }


            }else{
                return [
                    'success'=>false,
                    'error'=>true,
                    'message'=>'Chat id not found'
                ];
            }
        }else{
            return [
                'success'=>false,
                'error'=>true,
                'message'=>'Parametrlar yetarli emas'
            ];
        }
    }
    public function detectCardSystem($cardNumber)
    {
        $bin6 = substr($cardNumber, 0, 6);
        $bin4 = substr($cardNumber, 0, 4);
        $bin1 = substr($cardNumber, 0, 1);

        // Humo BIN’lari
        $humoBins = ['9860', '5614', '5610', '5611', '5612', '5613'];

        // UzCard BIN’lari
        $uzcardBins = ['8600', '8601', '8602', '8603', '8604', '8605', '8606', '8607', '8608', '8609'];

        if (in_array($bin4, $humoBins)) {
            return 'humo';
        } elseif (in_array($bin4, $uzcardBins)) {
            return 'uzcard';
        }
        return false;
    }

    public function getAllOrders($post){
        $chatId = $post['chatId'] ?? null;
        if($chatId){
            $client = Client::find()->where(['chat_id'=>$chatId])->one();
            if($client){
                $order = Transaction::find()->where(['client_id'=>$client->id])->orderBy(['id'=>SORT_DESC])->all();
                $data = [];
                foreach ($order as $item){
                    $data[] = [
                        'price'=>$item->price,
                        'orderId'=>$item->id,
                        'clientId'=>$client->id,
                        'state'=>$item->state,
                        'wallet'=>$item->wallet,
                    ];
                }
                return [
                    'success'=>true,
                    'error'=>false,
                    'data'=>$data
                ];
            }else{
                return [
                    'success'=>false,
                    'error'=>true,
                    'message'=>'Chat id not found'
                ];
            }
        }else{
            return [
                'success'=>false,
                'error'=>true,
                'message'=>'Chat id not found'
            ];
        }
    }

    public function getOrder($post){
        $chatId = $post['chatId'] ?? null;
        $orderId = $post['orderId'] ?? null;
        if ($chatId and $orderId){
            $client = Client::find()->where(['chat_id'=>$chatId])->one();
            $order = Transaction::findOne($orderId);
            if($client and $order){
                return [
                    'success'=>true,
                    'error'=>false,
                    'data'=>[
                        'orderId'=>$order->id,
                        'clientId'=>$client->id,
                        'state'=>$order->state,
                        'price'=>$order->price,
                        'created'=>$order->created,
                        'updated'=>$order->updated,
                        'isApproved'=>$order->is_approved ? true : false,
                        'wallet'=>$order->wallet,
                        'payment_url'=>$order->state=='PREPARE' ? 'https://pay2.octo.uz/pay/'.$order->uuid.'?language=uz' : null,
                    ]
                ];
            }else{
                return [
                    'success'=>false,
                    'error'=>true,
                    'message'=>'Chat id not found'
                ];
            }
        }else{
            return [
                'success'=>false,
                'error'=>true,
                'message'=>'Chat id not found'
            ];
        }
    }

    public function payout($post){
        $chatId = $post['chatId'] ?? null;
        $walletId = $post['walletId'] ?? null;
        $code = $post['code'] ?? null;
        $cardId = $post['cardId'] ?? null;

        if($chatId and $walletId and $code and $cardId){
            if($client = Client::find()->where(['chat_id'=>$chatId])->one()){

                $wallet = Wallet::findOne(['id'=>$walletId,'client_id'=>$client->id]);
                $card = Card::findOne(['id'=>$cardId,'client_id'=>$client->id]);
                if($wallet and $card){

                    $model = new Payout();
                    $model->client_id = $client->id;
                    $model->wallet_id = $wallet->id;
                    $model->card_id = $card->id;
                    $model->code = $code;
                    if($model->save()){

                        // send telegram
                        $domain = Yii::$app->request->hostInfo;
                        $path = '/cp/default/viewpayout';
                        $params = ['id' => $model->id];
                        $queryString = http_build_query($params);
                        $url = $domain . $path . '?' . $queryString;
                        $this->sendMessage("Pul chiqarish uchun yangi ariza qabul qilindi\n\n".$url);
                        return [
                            'success'=>true,
                            'error'=>false,
                            'message'=>'Sizning pul chiqarish bo`yicha arizangiz qabul qilindi. Arizangiz 1 minutdan 5 soatgacha ko`rib chiqiladi'
                        ];
                    }else{
                        Yii::$app->response->statusCode = 400;
                        return [
                            'success'=>false,
                            'error'=>true,
                            'message'=>'Pul chiqarish bo`yicha arizani qabul qilishda xato. Qayta urinib ko`ring'
                        ];
                    }

                }else{
                    Yii::$app->response->statusCode = 400;
                    return [
                        'success'=>false,
                        'error'=>true,
                        'message'=>'Wallet or card not found'
                    ];
                }
            }else{
                Yii::$app->response->statusCode = 400;
                return [
                    'success'=>false,
                    'error'=>true,
                    'message'=>'client not found'
                ];
            }


        }else{
            Yii::$app->response->statusCode = 400;
            return [
                'success'=>false,
                'error'=>true,
                'message'=>'Chat id not found'
            ];
        }



    }


    public function sendMessage($message)
    {
        $model = Telefy::find()->where(['status'=>1])->all();

        $url = "https://api.telegram.org/bot".Yii::$app->params['telefy'].'/sendMessage';
        foreach ($model as $item) {
            $data = [
                'chat_id' => $item->chat_id,
                'text'    => $message,
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $response = curl_exec($ch);
            curl_close($ch);
        }
    }
}
