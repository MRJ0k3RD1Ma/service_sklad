<?php
namespace frontend\components;

use common\models\Client;
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
            // barcha hisoblangan to'lovlarni yig'indisini olish
            // workerni balansiga qoldiq summani qo'shib qo'yish
            return true;
        }
        return false;
    }

    public static function calcPriceClient($id){
        $model = Client::findOne($id);
        if($model){
            // client bilan qilingan shartnomalarni umumiy narxini hisoblash
            // client to'lagan pullarning umumiy narxini hisoblash
            // clientning balansiga qolgan summani yozib qo'yish

            return true;
        }
        return false;
    }


}