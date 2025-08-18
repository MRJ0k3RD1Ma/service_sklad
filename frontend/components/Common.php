<?php
namespace frontend\components;

use common\models\Client;
use common\models\Sale;

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

    public static function ClientPaid($client_id){
        // avvalgi sotib olgan mahsulotlarining to'lovidan kamaytirish kerak.
        $client = Client::findOne($client_id);
        $sales = Sale::find()->where(['client_id'=>$client_id])
            ->andWhere(['>','credit',0])
            ->orderBy(['id'=>SORT_ASC])->all();
        foreach($sales as $sale){
            if($sale->credit > 0){
                if($client->balans > $sale->credit){
                    $sale->credit = 0;
                    $sale->debt = $sale->price;
                    $client->balans -= $sale->credit;
                    $client->credit -= $sale->credit;
                }else{
                    $sale->credit -= $client->balans;
                    $sale->debt += $client->balans;
                    $client->balans -= $sale->credit;
                    $client->credit -= $sale->credit;
                }
                $client->save(false);
                $sale->save(false);
            }
        }
    }


}