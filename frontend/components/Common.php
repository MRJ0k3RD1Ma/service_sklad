<?php
namespace frontend\components;

use common\models\Client;
use common\models\Paid;
use common\models\PaidWorker;
use common\models\Sale;
use common\models\Worker;

class Common extends \yii\base\Component
{
    public static function getphone($phone){
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

    public static function calcPriceWorker($id){
        $model = Worker::findOne($id);
        if($model){
            // barcha shartnoma bo'yicha hisoblangan pullarni yig'indisini olish
            $sale_price = Sale::find()->where(['status'=>1,'state'=>'DONE','worker_id'=>$model->id])->sum('total_price_worker');
            $paid_price = PaidWorker::find()->where(['status'=>1,'worker_id'=>$model->id])->sum('price');
            // barcha hisoblangan to'lovlarni yig'indisini olish
            // workerni balansiga qoldiq summani qo'shib qo'yish
            $model->balance = $sale_price - $paid_price;
            $model->save(false);
            return true;
        }
        return false;
    }

    public static function calcPriceClient($id){
        $model = Client::findOne($id);
        if($model){
            // client bilan qilingan shartnomalarni umumiy narxini hisoblash
            $sale_price = Sale::find()->where(['status'=>1,'state'=>'DONE','client_id'=>$model->id])->sum('price');
            // client to'lagan pullarning umumiy narxini hisoblash
            $paid_price = Paid::find()->where(['status'=>1,'client_id'=>$model->id])->sum('price');
            // clientning balansiga qolgan summani yozib qo'yish
            $model->balance = $paid_price - $sale_price;
            $model->save(false);
            return true;
        }
        return false;
    }


}