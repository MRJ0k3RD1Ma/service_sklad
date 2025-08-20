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
            'contract_id' => 'Contract',
            'price' => 'Price',
            'payment_id' => 'Payment',
            'client_id' => 'Client',
            'date' => 'Date',
            'status' => 'Status',
            'created' => 'Created At',
            'updated' => 'Updated At',
            'register_id' => 'Register ID',
            'modify_id' => 'Modify ID',
        ];
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
     * Relation: Sale
     */
    public function getSale()
    {
        return $this->hasOne(Sale::class, ['id' => 'contract_id']);
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
