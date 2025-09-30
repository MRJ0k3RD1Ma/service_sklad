<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "paid".
 *
 * @property int $id
 * @property int|null $sale_id
 * @property float $price
 * @property int $payment_id
 * @property int|null $client_id
 * @property string|null $date
 * @property int|null $status
 * @property string|null $created
 * @property string|null $updated
 * @property string|null $description
 * @property int|null $register_id
 * @property int|null $modify_id
 *
 * @property Client $client
 * @property User $register
 * @property User $modify
 * @property Payment $payment
 * @property Sale $sale
 */
class Paid extends ActiveRecord
{
    public static function tableName()
    {
        return 'paid';
    }

    public function rules()
    {
        return [
            [['price', 'payment_id','client_id','date'], 'required'],
            [['sale_id', 'payment_id', 'client_id', 'status', 'register_id', 'modify_id'], 'integer'],
            [['price'], 'number'],
            [['date', 'created', 'updated','description'], 'safe'],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['client_id' => 'id']],
            [['sale_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sale::class, 'targetAttribute' => ['sale_id' => 'id']],
            [['payment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Payment::class, 'targetAttribute' => ['payment_id' => 'id']],
            [['register_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['register_id' => 'id']],
            [['modify_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['modify_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sale_id' => 'Savdo',
            'price' => 'Summasi',
            'payment_id' => 'To‘lov turi',
            'client_id' => 'Mijoz',
            'description' => 'Izoh',
            'date' => 'Sana',
            'status' => 'Status',
            'created' => 'Kiritildi',
            'updated' => 'O`zgartirildi',
            'register_id' => 'Kiritdi',
            'modify_id' => 'O`zgartirdi',
        ];
    }

    public function getClient()
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
    }

    public function getSale()
    {
        return $this->hasOne(Sale::class, ['id' => 'sale_id']);
    }

    public function getPayment()
    {
        return $this->hasOne(Payment::class, ['id' => 'payment_id']);
    }

    public function getRegister()
    {
        return $this->hasOne(User::class, ['id' => 'register_id']);
    }

    public function getModify()
    {
        return $this->hasOne(User::class, ['id' => 'modify_id']);
    }


    public static function getYearlyData($year){
        $month = Yii::$app->params['month'];
        $res = [];
        foreach ($month as $key => $value) {
            if($value < 10){
                $m = '0'.$key;
            }
            $res[$key] = static::find()->where(['status'=>1])->andFilterWhere(['like','date',$year.'-'.$m.'-'])->sum('price');
            if(!$res[$key]){
                $res[$key] = 0;
            }
        }
        return array_values($res);
    }
}
