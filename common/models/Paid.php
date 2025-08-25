<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "paid".
 *
 * @property int $id
 * @property int|null $contract_id
 * @property float $price
 * @property int $payment_id
 * @property int|null $client_id
 * @property string|null $date
 * @property int|null $status
 * @property string|null $created
 * @property string|null $updated
 * @property int|null $register_id
 * @property int|null $modify_id
 *
 * @property Client $client
 * @property Payment $payment
 * @property Contract $contract
 * @property User $register
 * @property User $modify
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
            [['contract_id', 'payment_id', 'client_id', 'status', 'register_id', 'modify_id'], 'integer'],
            [['price'], 'required'],
            [['price'], 'number'],
            [['date', 'created', 'updated'], 'safe'],
            [['payment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Payment::class, 'targetAttribute' => ['payment_id' => 'id']],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['client_id' => 'id']],
            [['contract_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contract::class, 'targetAttribute' => ['contract_id' => 'id']],
            [['register_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['register_id' => 'id']],
            [['modify_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['modify_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'contract_id' => 'Shartnoma',
            'price' => 'Narxi',
            'payment_id' => 'To`lov turi',
            'client_id' => 'Mijoz',
            'date' => 'Sana',
            'status' => 'Status',
            'created' => 'Kiritildi',
            'updated' => 'O`zgartirildi',
            'register_id' => 'Kiritdi',
            'modify_id' => 'O`zgartirdi',
        ];
    }

    public function getMonths(){
        return [];
    }

    public function getYearlyData(){
        return [];
    }

    public function getTopProductsData(){
        return [];
    }
    /**
     * Relation: Client
     */
    public function getClient()
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
    }

    /**
     * Relation: Payment
     */
    public function getPayment()
    {
        return $this->hasOne(Payment::class, ['id' => 'payment_id']);
    }


    /**
     * Relation: User (Register)
     */
    public function getRegister()
    {
        return $this->hasOne(User::class, ['id' => 'register_id']);
    }

    /**
     * Relation: User (Modify)
     */
    public function getModify()
    {
        return $this->hasOne(User::class, ['id' => 'modify_id']);
    }
}
