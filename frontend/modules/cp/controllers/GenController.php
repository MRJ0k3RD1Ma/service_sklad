<?php

namespace frontend\modules\cp\controllers;

use common\models\Client;
use common\models\ClientType;
use common\models\Come;
use common\models\ComeProduct;
use common\models\Custom;
use common\models\Goods;
use common\models\Paid;
use common\models\PaidClient;
use common\models\Sale;
use common\models\SaleClient;
use common\models\SaleCredit;
use common\models\SaleProduct;
use common\models\Suppler;
use common\models\SupplerReturn;
use common\models\SupplerReturnProduct;
use frontend\components\TGBot;
use Yii;
use yii\web\Controller;

class GenController extends Controller{


    public function beforeAction($action)
    {
        if ($action->id === 'print' or $action->id == 'saled') { // Faqat `print` amali uchun
            Yii::$app->request->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionSale(){
        $this->layout = "gen";
        return $this->render('sale');
    }

    public function actionIncome(){
        $model = new Come();
        if($model->load($this->request->post())){
            $model->suppler_phone = $this->getphone($model->suppler_phone);
            if($model->suppler_phone == false){
                $model->addError('suppler_phone','Telefon raqam xato kiritildi');
                return $this->render('income',[
                    'model' => $model
                ]);
            }else{
                $suppler = Suppler::findOne(['phone'=>$model->suppler_phone]);
                if($suppler) {
                    $model->suppler_id = $suppler->id;
                }
            }
            if($model->suppler_id == -1){

                $suppler = new Suppler();
                $suppler->name = $model->suppler_name;
                $suppler->phone = $model->suppler_phone;
                $suppler->save(false);
                $model->suppler_id = $suppler->id;

            }else{
                $suppler = Suppler::findOne($model->suppler_id);
            }
            $model->register_id = Yii::$app->user->id;
            $order = [];
            if(Yii::$app->session->has('income')){
                $order = Yii::$app->session->get('income');
            }
            $price = 0;
            foreach ($order as $item){
                $price += $item['cnt_price'];
            }
            $model->price = $price;
            $suppler->balans += $price;
            $suppler->credit += $price;
            $suppler->debt = 0;
            $suppler->save(false);
            $code = date('ym');
            $id = Come::find()->filterWhere(['like','date',date('Y-m-')])->max('code_id');
            if(!$id){
                $id = 0;
            }

            $id ++;
            $code .= $id;
            $model->code = $code;
            $model->code_id = $id;
            if($model->save()){

                foreach ($order as $item){
                    $m = new ComeProduct();
                    $m->goods_id = $item['id'];
                    $m->come_id = $model->id;
                    $m->cnt_price = $item['cnt_price'];
                    $m->price = $item['price'];
                    $m->cnt = $item['cnt'];
                    $id = ComeProduct::find()->where(['come_id' => $model->id,'goods_id'=>$m->goods_id])->max('id');
                    if(!$id){
                        $id = 0;
                    }
                    $id ++;
                    $m->id = $id;
                    $m->save(false);
                    // change product count
                    $t = Goods::findOne(['id'=>$m->goods_id]);
                    $t->come += $m->cnt;
                    $t->remainder += $m->cnt;
                    $t->save(false);
                }
            }

            if(Yii::$app->session->has('income')){
                Yii::$app->session->remove('income');
            }

            return $this->redirect(['/cp/come','id'=>$model->id]);

        }
        return $this->render('income',[
            'model' => $model
        ]);
    }

    public function actionReturntosuppler(){
        $model = new SupplerReturn();
        if($model->load($this->request->post())){
            if($model->suppler_id == -1){
                $suppler = new Suppler();
                $suppler->name = $model->suppler_name;
                $suppler->phone = $model->suppler_phone;
                $suppler->save(false);
                $model->suppler_id = $suppler->id;
            }else{
                $suppler = Suppler::findOne($model->suppler_id);
            }
            $model->register_id = Yii::$app->user->id;
            $order = [];
            if(Yii::$app->session->has('retsup')){
                $order = Yii::$app->session->get('retsup');
            }
            $price = 0;
            foreach ($order as $item){
                $price += $item['cnt_price'];
            }
            $model->price = $price;
            $suppler->balans -= $price;
            $suppler->credit -= $price;
            $suppler->debt = 0;
            $suppler->save(false);
            $code = date('ym');
            $id = SupplerReturn::find()->filterWhere(['like','date',date('Y-m-')])->max('code_id');
            if(!$id){
                $id = 0;
            }

            $id ++;
            $code .= $id;
            $model->code = $code;
            $model->code_id = $id;
            if($model->save()){

                foreach ($order as $item){
                    $m = new SupplerReturnProduct();
                    $m->goods_id = $item['id'];
                    $m->come_id = $model->id;
                    $m->cnt_price = $item['cnt_price'];
                    $m->price = $item['price'];
                    $m->cnt = $item['cnt'];
                    $id = SupplerReturnProduct::find()->where(['come_id' => $model->id,'goods_id'=>$m->goods_id])->max('id');
                    if(!$id){
                        $id = 0;
                    }
                    $id ++;
                    $m->id = $id;
                    $m->save(false);
                    // change product count
                    $t = Goods::findOne(['id'=>$m->goods_id]);
                    $t->come -= $m->cnt;
                    $t->remainder -= $m->cnt;
                    $t->save(false);
                }
            }

            if(Yii::$app->session->has('retsup')){
                Yii::$app->session->remove('retsup');
            }

            return $this->redirect(['/cp/suppler-return','id'=>$model->id]);

        }
        return $this->render('returntosuppler',[
            'model' => $model
        ]);
    }


    public function actionGetgoods($id){

        $model = Goods::find()->where(['status'=>1,'group_id'=>$id])->all();
        $res = "";
        $u = false;
        foreach ($model as $item){
            $img =  $item->image == 'default/nophoto.png' ? '/upload/default/nophoto.png' : '/upload/goods/'.$item->image;
            $price = $item->price;
            if($item->price_type == 'RATE'){
                $price = $price * Custom::findOne(['key'=>'exchange-rate'])->value;
            }
            $res .= "<div class='bg-white rounded-lg shadow px-4 goods-items' data-id='{$item->id}' data-price='{$price}' data-img='{$img}'>
                            <img src='{$img}' class='w-full h-32 object-cover rounded-lg'/>
                            <h3 class='font-semibold'>{$item->name}</h3>
                            <p class='text-gray-600 goods-item-price'>{$price} so'm</p>
                     </div>";
            $u = true;
        }
        if($u){
            return $res;
        }else{
            return -1;
        }
    }

    public function actionSearchgoods($name,$type){

        $model = Goods::find()->where(['status'=>1,'type'=>$type])
            ->andWhere('name like "%'.$name.'%" or barcode like "%'.$name.'%"')
            ->all();
        $res = "";
        $u = false;
        foreach ($model as $item){
            $img =  $item->image == 'default/nophoto.png' ? '/upload/default/nophoto.png' : '/upload/goods/'.$item->image;
            $price = $item->price;
            if($item->price_type == 'RATE'){
                $price = $price * Custom::findOne(['key'=>'exchange-rate'])->value;
            }
            $res .= "<div class='bg-white rounded-lg shadow px-4 goods-items' data-id='{$item->id}' data-price='{$price}' data-img='{$img}'>
                            <img src='{$img}' class='w-full h-32 object-cover rounded-lg'/>
                            <h3 class='font-semibold'>{$item->name}</h3>
                            <p class='text-gray-600 goods-item-price'>{$price} so'm</p>
                     </div>";
            $u = true;
        }
        if($u){
            return $res;
        }else{
            return -1;
        }
    }

    public function actionGetgoodssale($id){

        $model = Goods::find()->where(['status'=>1,'group_id'=>$id])->all();
        $res = "";
        $u = false;
        foreach ($model as $item){
            $img =  $item->image == 'default/nophoto.png' ? '/upload/default/nophoto.png' : '/upload/goods/'.$item->image;
            $price = $item->price;
            if($item->price_type == 'RATE'){
                $price = $price * Custom::findOne(['key'=>'exchange-rate'])->value;
            }
            $res .= "<div class='bg-white rounded-lg shadow px-4 goods-items' data-id='{$item->id}' data-price='{$price}' data-img='{$img}'>
                            <img src='{$img}' class='w-full h-32 object-cover rounded-lg'/>
                            <h3 class='font-semibold'>{$item->name}</h3>
                            <p class='text-gray-600 goods-item-price'>{$price} so'm</p>
                     </div>";
            $u = true;
        }
        if($u){
            return $res;
        }else{
            return -1;
        }
    }

    public function actionIncomeorder($id,$price,$cnt,$name)
    {
        if(!Yii::$app->session->has('income')){
            $order = [];
        }else{
            $order = Yii::$app->session->get('income');
        }
        if(array_key_exists($id,$order)){
            $order[$id]['cnt'] += $cnt;
        }else{
            $model = Goods::findOne($id);
            $order[$id] = [
                'id' => $id,
                'cnt' => $cnt,
                'barcode'=>$model->barcode,
                'price' => $price,
                'name' => $name,
                'cnt_price'=>$cnt*$price,
            ];
        }
        Yii::$app->session->set('income',$order);
        return json_encode($order);
    }

    public function actionIncomeorderremove($id)
    {
        if(!Yii::$app->session->has('income')){
            $order = [];
        }else{
            $order = Yii::$app->session->get('income');
        }

        // Remove the item with the given ID if it exists
        if(array_key_exists($id, $order)){
            unset($order[$id]);
        }

        Yii::$app->session->set('income', $order);
        return json_encode($order);
    }

    public function actionReturnorder($id,$price,$cnt,$name)
    {
        if(!Yii::$app->session->has('retsup')){
            $order = [];
        }else{
            $order = Yii::$app->session->get('retsup');
        }
        if(array_key_exists($id,$order)){
            $order[$id]['cnt'] += $cnt;
        }else{
            $model = Goods::findOne($id);
            $order[$id] = [
                'id' => $id,
                'cnt' => $cnt,
                'barcode'=>$model->barcode,
                'price' => $price,
                'name' => $name,
                'cnt_price'=>$cnt*$price,
            ];
        }
        Yii::$app->session->set('retsup',$order);
        return json_encode($order);
    }

    public function actionReturnorderremove($id)
    {
        if(!Yii::$app->session->has('retsup')){
            $order = [];
        }else{
            $order = Yii::$app->session->get('retsup');
        }
        if(array_key_exists($id,$order)){
            unset($order[$id]);
        }
        Yii::$app->session->set('retsup',$order);
        return json_encode($order);
    }
    public function actionGetone($id)
    {
        if($model = Goods::findOne($id)){
            $img =  $model->image == 'default/nophoto.png' ? '/upload/default/nophoto.png' : '/upload/goods/'.$model->image;
            $rem = $model->remainder;
            if($model->type == 2){
                $rem = 9999999;
            }
            $rem = 9999999;
            $price = $model->price;
            if($model->price_type == 'RATE'){
                $price = $price * Custom::findOne(['key'=>'exchange-rate'])->value;
            }
            return json_encode([
                'id'=>$model->id,
                'name'=>$model->name,
                'price'=>$price,
                'option'=>$rem,
                'image'=>$img,
                'type'=>$model->type
            ]);
        }
    }

    public function actionScan($code)
    {
       if($model = Goods::findOne(['barcode'=>$code])){
       $img =  $model->image == 'default/nophoto.png' ? '/upload/default/nophoto.png' : '/upload/goods/'.$model->image;
           $rem = $model->remainder;
           if($model->type == 2){
               $rem = 9999999;
           }
           $rem = 9999999;
           $price = $model->price;
           if($model->price_type == 'RATE'){
               $price = $price * Custom::findOne(['key'=>'exchange-rate'])->value;
           }
           $res = [
               'id'=>$model->id,
               'name'=>$model->name,
               'barcode'=>$model->barcode,
               'price'=>$price,
               'ostatka'=>$rem,
               'image'=>$img,
           ];
           return json_encode($res);
       }
        return -1;
    }

    public function actionEmpty()
    {
        if(Yii::$app->session->has('income')){
            Yii::$app->session->remove('income');
        }
    }

    public function actionGetsuppler($name,$phone)
    {
        $model = Suppler::find()->filterWhere(['like','name',$name])->andFilterWhere(['like','phone',$phone])->all();
        $res = "";
        foreach ($model as $item){
            $res .= "<li data-id='{$item->id}' data-name='{$item->name}' data-phone='{$item->phone}'>{$item->name} - {$item->phone}</li>";
        }
        return $res;
    }
    public function actionGetproduct($name)
    {
        $model = Goods::find()->filterWhere(['like','name',$name])->orFilterWhere(['like','barcode',$name])->andWhere(['type'=>1])->all();
        $res = "";
        foreach ($model as $item){
            $price = $item->price_come;

            $res .= "<li data-id='{$item->id}' data-name='{$item->name}' data-ostatka='{$item->remainder}' data-price='{$price}'>{$item->barcode} - {$item->name}</li>";
        }
        return $res;
    }
    public function actionGetclient($name,$phone)
    {
        $model = Client::find()->filterWhere(['like','name',$name])->andFilterWhere(['like','phone',$phone])->all();
        $res = "";
        foreach ($model as $item){
            $res .= "<li data-id='{$item->id}' data-name='{$item->name}' data-image='{$item->image}' data-phone='{$item->phone}'>{$item->name} - {$item->phone}</li>";
        }
        return $res;
    }

    public function actionPrint()
    {
        $this->layout = false;
        $data = json_decode(file_get_contents('php://input'), true);
        return $this->render('sale/_print',[
            'model'=>$data
        ]);
        exit;
    }
    public function getphone($phone){
        $phone_new = "";
        if(strlen($phone) < 9 ){
            return false;
        }
        for ($i=0; $i<strlen($phone);  $i++){
            if('0'<=$phone[$i] and $phone[$i] <= '9'){
                $phone_new.= $phone[$i];
            }
        }
        if(strlen($phone_new) > 9){
            if($phone_new[0]=='9' and $phone_new[1]=='9' and $phone_new[2]=='8'){
                $phone_new = substr($phone_new,3,strlen($phone_new));
            }else{
                return false;
            }
        }
//        (99)967-0395

        return '('.substr($phone_new,0,2).')'.substr($phone_new,2,3).'-'.substr($phone_new,5,4);
    }
    public function  actionSaled()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = json_decode(file_get_contents('php://input'), true);
        if ($data === null) {
            // Agar JSON noto'g'ri bo'lsa, xatolik qaytariladi
            return [
                'status' => 'error',
                'message' => 'Invalid JSON data'
            ];
        }
        $model = new Sale();
        $model->user_id = Yii::$app->user->id;
        $model->created = date('Y-m-d H:i:s');
        $model->price = 0;
        $code = Sale::find()->filterWhere(['like','created',date('Y-m')])->max('code_id');
        if(!$code){
            $code = 0;
        }
        $code ++;
        $model->code_id = $code;
        $model->code = date('ym').$code;
        if($model->save()){

            $price = 0;
            foreach ($data['cart'] as $item){
                $m = new SaleProduct();
                $uid = isset($item['user_id']) ? $item['user_id'] : Yii::$app->user->id;
                $m->user_id = intval($uid);
                $m->sale_id = $model->id;
                $m->product_id = intval($item['productId']);
                $m->price = $item['price'] * 1.0;
                $m->cnt = $item['qty'] * 1.0;
                $m->cnt_price = $m->price * $m->cnt * 1.0;
                $m->save();
                $price += $m->cnt_price;

                $t = Goods::findOne(['id'=>$m->product_id]);
                $t->sale += $m->cnt;
                $t->remainder -= $m->cnt;
                $t->save(false);

            }
            $model->price = $price;
            if($data['sotuvturi'] == 'qarz'){
                $model->debt = 0;
                $model->credit = $price;
                // qarzdorni kiritish
                $credit = new SaleCredit();
                $credit->sale_id = $model->id;
                $credit->price = $model->credit;
                $credit->status = 1;
                $credit->state = 1;
                $credit->user_id = $model->user_id;
                $credit->call_date = date('Y-m-d',strtotime($data['paydate']));

                if($data['qarzdor_id'] != -1){
                    if($qarzdor = Client::findOne($data['qarzdor_id'])){
                        $credit->client_id = $qarzdor->id;
                        $qarzdor->balans -= $price;
                        $qarzdor->credit += $price;
                        $qarzdor->save();

                    }else{
                        $qarzdor = new Client();
                        $qarzdor->name = $data['qarzdor_name'];
                        $qarzdor->phone = $this->getphone($data['qarzdor_phone']);
                        $qarzdor->type_id = 1;
                        $qarzdor->balans = -1*$price;
                        $qarzdor->credit = $price;
                        $qarzdor->debt = 0;
                        $qarzdor->save();
                        $credit->client_id = $qarzdor->id;

                    }
                }else{
                    if($data['qarzdor_name'] != '' and $data['qarzdor_phone'] != ''){
                        $qarzdor = new Client();
                        $qarzdor->name = $data['qarzdor_name'];
                        $qarzdor->phone = $this->getphone($data['qarzdor_phone']);
                        $qarzdor->type_id = 1;
                        $qarzdor->balans = -1*$price;
                        $qarzdor->credit = $price;
                        $qarzdor->debt = 0;
                        $qarzdor->save();
                        $credit->client_id = $qarzdor->id;
                    }
                }
                // telefonlashish uchun sale_creditni shakllantirish
                // sale qilingan narsalarni skladdan olib tashlash
                $model->credit = $price;
                $model->debt = 0;
                $credit->save(false);
                $s = new SaleClient();
                $s->client_id = $qarzdor->id;
                $s->sale_id = $model->id;
                $s->save(false);
            }else{
                $qarzdor = null;
                if($data['qarzdor_name'] != '' and $data['qarzdor_phone'] != ''){
                    if($q = Client::findOne($data['qarzdor_id'])){
                        $qarzdor = $q;
                    }elseif($q = Client::findOne(['status'=>1,'phone'=>$this->getphone($qarzdor['qarzdor_phone'])])){
                        $qarzdor = $q;
                    }else{
                        $qarzdor = new Client();
                        $qarzdor->name = $data['qarzdor_name'];
                        $qarzdor->phone = $this->getphone($data['qarzdor_phone']);
                        $qarzdor->debt = 0;
                    }
                    $qarzdor->type_id = 1;
                    $qarzdor->debt += $price;
                    $qarzdor->save();
                    $sale_client = new SaleClient();
                    $sale_client->client_id = $qarzdor->id;
                    $sale_client->sale_id = $model->id;
                    $sale_client->save(false);
                }

                $model->debt = $price;
                $model->credit = 0;
                $paid = new Paid();
                $paid->sale_id = $model->id;
                $paid->price = $price;
                $paid->payment_id = $data['paidtype'];
                $paid->date = date('Y-m-d');
                $paid->register_id = Yii::$app->user->id;
                $paid->modify_id = Yii::$app->user->id;
                $paid->type = 1;
                $paid->save(false);
                if($qarzdor){
                    $pq = new PaidClient();
                    $pq->client_id = $qarzdor->id;
                    $pq->paid_id = $paid->id;
                    $pq->save();
                }


            }
            $model->save(false);


//            // implement payment and paid table
//            $res = TGBot::sendHtmlAsImage('86419074',Yii::$app->urlManager->createAbsoluteUrl(['/site/salednotprint','id'=>$model->id]));
//
//            file_put_contents(__DIR__.'/log_res.log', $res);

            return [
                'status' => 'success',
                'sale_id' => $model->id,
            ];
        }
        return [
            'status' => 'error',
        ];
    }


    public function actionSaledprint($id)
    {
        if($model = Sale::findOne($id)){
            return $this->renderAjax('sale/_saledprint',[
                'model'=>$model
            ]);
        }
        return -1;
    }


}